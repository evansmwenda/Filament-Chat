<x-layouts.app title="Chats" >
    <div class="flex h-[92vh] overflow-hidden">
        <div class="w-1/3 bg-white flex flex-col justify-center items-center">
            <livewire:ChatList/>
        </div>
        <div class="w-2/3 flex flex-col justify-center items-center">
            <livewire:ChatWindow/>
        </div>
    </div>
</x-layouts.app>

