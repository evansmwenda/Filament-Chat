<div class="flex flex-col bg-red-500">
    @if($conversation)
        <div class="flex-1 messages p-4">
            @foreach($messages as $message)
                <div>{{ $message->message }}</div>
            @endforeach
        </div>
        <div class="send-message p-4 flex-none">
            <input type="text" wire:model="messageText" class="w-3/4 p-2 border border-gray-300 rounded" />
            <button wire:click="sendMessage" class="w-1/4 p-2 bg-blue-500 text-white rounded">Send</button>
        </div>
    @else
        <div class="flex items-center justify-center h-full p-4">
            <h4 class="font-medium text-lg text-green-500">Choose a conversation to start chatting</h4>
        </div>
    @endif
</div>

