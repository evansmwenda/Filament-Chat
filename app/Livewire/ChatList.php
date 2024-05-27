<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class ChatList extends Component
{
    public $query;
    public $conversations;
    public $selectedConversation;
    protected $listeners=['refresh'=>'$refresh'];

    public function mount()
    {
        $user = auth()->user();
        // $this->conversations= Conversation::where('sender_id',$user->id)->orWhere('receiver_id',$user->id)->get();
        $this->conversations = $user->conversations()->latest('updated_at')->get();
       //set unread messages in conversation thread of current user as read
    //    Message::where('conversation_id',$this->selectedConversation->id)
    //         ->where('receiver_id',auth()->id())
    //         ->whereNull('read_at')
    //         ->update(['read_at'=>now()]);
    }


    public function render()
    {
        return view('livewire.chat-list');
    }

    public function selectConversation($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        $this->selectedConversation = $conversation;
        $this->dispatch('conversationSelected', ['conversation' => $conversation]);
    }
}
