<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class ChatWindow extends Component
{
    public $conversation;
    public $messages;

    public $messageText;

    protected $listeners = ['conversationSelected' => 'loadMessages'];

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
        $this->messages = Message::where('conversation_id', $this->conversation->id)
            ->where(function ($query) use($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
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

        
        \App\Models\Message::create([
            'conversation_id' => $this->conversation->id,
            'message' => $this->messageText,
            'sender_id' => auth()->user()->id,
            'receiver_id' => $this->conversation->receiver_id,
        ]);
        $this->messageText = '';
        $data['conversation'] = $this->conversation;
        $this->loadMessages($data);

        $this->dispatch('scroll-bottom');
    }

    public function render()
    {
        return view('livewire.chat-window');
    }
}
