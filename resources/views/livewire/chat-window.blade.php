<div>
    @if($conversationId)
        <div class="messages">
            @foreach($messages as $message)
                <div>{{ $message->message }}</div>
            @endforeach
        </div>
        <div class="send-message">
            <input type="text" wire:model="messageText" />
            <button wire:click="sendMessage">Send</button>
        </div>
    @else
        <div><h4 class="font-medium text-lg"> Choose a conversation to start chatting </h4></div>
    @endif
</div>

