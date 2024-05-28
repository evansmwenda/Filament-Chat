<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    //get receiver user object in the conversation
    public function getReceiver()
    {
        if($this->sender_id === auth()->id()){
            return User::firstWhere('id',$this->receiver_id);
        }else{
            return User::firstWhere('id',$this->sender_id);
        }
    }

    //get count of unready messages in conversation
    public  function unreadMessagesCount()
    {
        $unreadMessages= Message::where('conversation_id','=',$this->id)
        ->where('receiver_id',auth()->user()->id)
        ->whereNull('read_at')->count();

        // dd($unreadMessages);

        return $unreadMessages;
    }

    //check if latest message is read
    public  function isLastMessageReadByUser()
    {
        $user=Auth()->User();
        $lastMessage= $this->messages()->latest()->first();
        
        if($lastMessage){
            return  $lastMessage->read_at !==null && $lastMessage->sender_id == $user->id;
        }
        
    }
}
