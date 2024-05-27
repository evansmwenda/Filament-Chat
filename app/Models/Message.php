<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'receiver_id',
        'message',
        'read_at'
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    //check if message has been read
    public function isRead()
    {
        return $this->read_at != null;
    }

    //return sender name
    public function getSenderEmail()
    {
        return User::firstWhere('id',$this->sender_id)->email;
    }

    //return receiver name
    public function getReceiverEmail()
    {
        return User::firstWhere('id',$this->receiver_id)->email;
    }
}
