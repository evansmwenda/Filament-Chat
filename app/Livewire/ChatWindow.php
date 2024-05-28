<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\MessageRead;
use App\Notifications\MessageSent;
use Livewire\Component;

class ChatWindow extends Component
{
    public $conversation;
    public $messages;

    public $messageText;

    // protected $listeners = ['conversationSelected' => 'loadMessages'];

    public function loadMessages($payload)
    {
        $userId = auth()->id();
        $this->conversation = Conversation::find($payload['conversation']['id']);

        #get count
        $count = Message::where('conversation_id', $this->conversation->id)    
            ->where(function ($query) use($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->count();

        #skip and query
        // dd($this->conversation->id);
        $this->messages = Message::where('conversation_id', $this->conversation->id)
            // ->where(function ($query) use($userId) {
            //     $query->where('sender_id', $userId)
            //         ->orWhere('receiver_id', $userId);
            // })
            // ->skip($count - $this->paginate_var)
            // ->take($this->paginate_var)
            ->get();

            //scroll to bottom
            $this->dispatch('scroll-bottom');

        return $this->messages;
    }

    public function sendMessage()
    {
        if(strlen(trim($this->messageText)) < 3){
            return ;
        }

        
        $createdMessage = Message::create([
            'conversation_id' => $this->conversation->id,
            'message' => $this->messageText,
            'sender_id' => auth()->user()->id,
            'receiver_id' => $this->conversation->getReceiver()->id
        ]);
        $this->messageText = '';
        $data['conversation'] = $this->conversation;
        $this->loadMessages($data);

        $this->dispatch('scroll-bottom');

        //update conversation model
        $this->conversation->updated_at = now();
        $this->conversation->save();


        //refresh chatlist
        $this->dispatch('refresh')->to('chat-list');

        // broadcast notification now
        $this->conversation->getReceiver()
            ->notify(new MessageSent(
                Auth()->User(),
                $createdMessage,
                $this->conversation,
                $this->conversation->getReceiver()->id
            ));

            // $this->conversation->getReceiver()
            // ->notify(
            //     Notification::make()
            //         ->title('Saved successfully')
            //         ->toBroadcast(),
            // );
    }

    public function getListeners()
    {
        $auth_id = auth()->user()->id;
        return [
            'conversationSelected' => 'loadMessages',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated" => 'broadcastedNotifications'
        ];
    }

    public function broadcastedNotifications($event)
    {
        if ($event['type'] == MessageSent::class) {
            if ($event['conversation_id'] == $this->conversation?->id) {
                $this->dispatch('scroll-bottom');

                $newMessage = Message::find($event['message_id']);

                //push message
                $this->messages->push($newMessage);

                //mark as read
                $newMessage->read_at = now();
                $newMessage->save();

                //broadcast 
                $this->conversation->getReceiver()
                    ->notify(new MessageRead($this->conversation->id));  
            }
        }
    }

    public function render()
    {
        return view('livewire.chat-window');
    }
}
