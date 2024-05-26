<x-filament::page>
    <div class="flex h-screen lg:h-[90%] bg-red-500 lg:shadow-sm overflow-hidden lg:top-16 lg:inset-x-2 m-auto rounded-t-lg">
        <div class="w-1/3 border-r relative md:w-[320px] xl:w-[400px] overflow-y-auto shrink-0 h-full">
            <livewire:ChatList/>
        </div>
        <div class="w-2/3 h-full relative overflow-y-auto" style="contain:content">
            <livewire:ChatWindow/>
        </div>
    </div>
</x-filament::page>






