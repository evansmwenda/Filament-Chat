<div>
    <ul>
        @foreach($conversations as $conversation)
            <li wire:click="selectConversation({{ $conversation->id }})">
                {{ $conversation->getReceiver()->name }}
            </li>
        @endforeach
    </ul>
</div>
