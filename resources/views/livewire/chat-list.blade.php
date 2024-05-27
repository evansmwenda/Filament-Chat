<div class="flex flex-col h-full w-full">
    <header class="px-3 z-10 bg-white sticky top-0 py-1 w-full">
        <div class="border-b justify-between flex items-center pb-2">
            <div class="flex items-center gap-2">
                <h5 class="font-extrabold text-xl">Chats</h5>
            </div>
        </div>
    </header>

    <main class="overflow-y-scroll overflow-hidden grow w-full" style="contain:content">
        <ul class="p-2 grid w-full space-y-2">
            @if ($conversations)
                @foreach ($conversations as $key => $conversation)
                    <li wire:click="selectConversation({{ $conversation->id }})"
                        class="py-3 hover:bg-gray-300 rounded-2xl dark:hover:bg-gray-700/70 transition-colors duration-150 flex gap-4 relative w-full cursor-pointer px-2 {{ $conversation->id == $selectedConversation?->id ? 'bg-gray-200/70':'' }}">
                        <!-- Your list item content here -->
                        <x-filament::avatar src="https://gravatar.com/avatar/27205e5c51cb03f862138b22bcb5dc20f94a342e744ff6df1b8dc8af3c865109" alt="Dan Harrin"/>
                        <aside class="grid grid-cols-12 w-full">
                            {{-- name and date  --}}
                            <div class="col-span-12 flex justify-between items-center">
                                <h6 class="truncate font-medium tracking-wider text-gray-900">
                                    {{$conversation->getReceiver()->name}}
                                </h6>
                                <small class="text-gray-700">{{$conversation->messages?->last()?->created_at?->shortAbsoluteDiffForHumans()}} </small>
                            </div>
                            {{-- Message body --}}
                            <div class="col-span-12 flex gap-x-2 items-center">

                                @if ($conversation->messages?->last()?->sender_id==auth()->id())
                                    @if ($conversation->isLastMessageReadByUser())
                                            <!-- double tick -->
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                            <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                                            <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
                                        </svg>
                                    </span>
                                    @else

                                        <!-- single tick -->
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                        </span>
                                            
                                    @endif
                                @endif

                                <p class="grow truncate text-sm font-[100]">
                                {{$conversation->messages?->last()?->message??' '}}
                                </p>

                                <!-- unread count ONLY if we are the receiver-->
                                @if ($conversation->messages?->last()?->sender_id != auth()->id())
                                    @if ($conversation->unreadMessagesCount()>0)
                                    <span class="font-bold p-px px-2 text-xs shrink-0 rounded-full bg-blue-500 text-white">
                                        {{$conversation->unreadMessagesCount()}}
                                    </span>
                                        
                                    @endif
                                @endif

                                </div>
                        </aside>
                    </li>
                @endforeach
            @endif
        </ul>
    </main>
</div>
