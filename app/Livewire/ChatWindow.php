<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;

class ChatWindow extends Component
{
    public $conversationId;
    public $messages;
    public $messageText;

    protected $listeners = ['conversationSelected' => 'loadMessages'];

    public function loadMessages($payload)
    {
        $userId = auth()->id();
        $this->conversationId = $payload['conversationId'];

        // dd($this->conversationId);

        #get count
        $count = Message::where('conversation_id', $this->conversationId)    
            ->where(function ($query) use($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            ->count();

        #skip and query
        $this->messages = Message::where('conversation_id', $this->conversationId)
            ->where(function ($query) use($userId) {
                $query->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })
            // ->skip($count - $this->paginate_var)
            // ->take($this->paginate_var)
            ->get();


        return $this->messages;
    }

    public function sendMessage()
    {
        \App\Models\Message::create([
            'contact_id' => $this->contactId,
            'text' => $this->messageText,
        ]);
        $this->messageText = '';
        $this->loadMessages($this->contactId);
    }

    public function render()
    {
        return view('livewire.chat-window');
    }
}
