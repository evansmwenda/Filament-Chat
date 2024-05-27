<div class="flex flex-col w-full h-full bg-white">
    @if($conversation)
        <header class="w-full sticky inset-x-0 flex pb-[5px] pt-[5px] top-0 z-10 bg-white border-b " >
            <div class="flex w-full items-center px-2 lg:px-4 gap-2 md:gap-5">
                <a class="shrink-0 lg:hidden" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
                    </svg>
                </a>
                <div class="shrink-0">
                    <x-filament::avatar src="https://via.placeholder.com/100" class="h-9 w-9 lg:w-11 lg:h-11" alt="Dan Harrin"/>
                </div>
                <h6 class="font-bold truncate"> {{$conversation->getReceiver()->email}} </h6>
            </div>
        </header>

        <main 
        class="flex flex-col gap-3 p-2.5 overflow-y-auto  flex-grow overscroll-contain overflow-x-hidden w-full my-auto"
        >
            @foreach($messages as $key => $message)
                <div
                    wire:key="{{time().$key}}"
                    @class([
                        'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2',
                        'ml-auto'=>$message->sender_id=== auth()->id(),
                    ]) >

                    {{-- messsage body --}}
                    <div @class(['flex flex-wrap text-[15px]  rounded-xl p-2.5 flex flex-col text-black bg-[#f6f6f8fb]',
                                'rounded-bl-none border  border-gray-200/40 '=>!($message->sender_id=== auth()->id()),
                                'rounded-br-none bg-green-500/80 text-white'=>$message->sender_id=== auth()->id()
                        ])>
                        <p @class([
                                'whitespace-normal truncate text-sm md:text-base tracking-wide lg:tracking-normal',
                                'text-black'=>!($message->sender_id=== auth()->id()),
                                'text-white'=>$message->sender_id=== auth()->id(),
                            ])>
                        {{$message->message}}
                        </p>

                        <div class="ml-auto flex gap-2">
                            <p @class([
                                'text-xs ',
                                'text-gray-900'=>!($message->sender_id=== auth()->id()),
                                'text-white'=>$message->sender_id=== auth()->id(),

                                    ]) >
                                {{$message->created_at->format('g:i a')}}
                            </p>

                            {{-- message status , only show if message belongs auth --}}
                            @if ($message->sender_id=== auth()->id())
                                <div x-data="{markAsRead:@json($message->isRead())}">
                                    {{-- double ticks --}}

                                    <span x-cloak x-show="markAsRead" @class('text-gray-200')>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-all" viewBox="0 0 16 16">
                                            <path d="M12.354 4.354a.5.5 0 0 0-.708-.708L5 10.293 1.854 7.146a.5.5 0 1 0-.708.708l3.5 3.5a.5.5 0 0 0 .708 0l7-7zm-4.208 7-.896-.897.707-.707.543.543 6.646-6.647a.5.5 0 0 1 .708.708l-7 7a.5.5 0 0 1-.708 0z"/>
                                            <path d="m5.354 7.146.896.897-.707.707-.897-.896a.5.5 0 1 1 .708-.708z"/>
                                        </svg>
                                    </span>

                                    {{-- single ticks --}}
                                    <span x-show="!markAsRead" @class('text-gray-200')>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                        </svg>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
                            </main>

        <div class="send-message p-4 flex items-center space-x-2">
            <input 
                type="text" 
                wire:model="messageText"
                wire:keydown.enter="sendMessage"
                class="flex-grow p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500"
                autocomplete="off"
                autofocus
                maxlength="1700"
                required
                placeholder="Type your message..."/>
            <button
             wire:click="sendMessage"
             @if(empty($messageText)) disabled @endif
             class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Send</button>
        </div>

    @else
        <div class="flex w-full items-center justify-center h-full py-6">
            <h4 class="font-medium text-lg">Choose a conversation to start chatting</h4>
        </div>
    @endif
</div>
