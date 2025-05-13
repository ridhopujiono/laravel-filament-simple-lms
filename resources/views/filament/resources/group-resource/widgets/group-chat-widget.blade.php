
    <x-filament::section>
        <div class="overflow-y-auto mb-4">
            @foreach ($group->discussions()->latest()->take(30)->get()->reverse() as $msg)
                <div class="flex {{ $msg->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="bg-{{ $msg->user_id === auth()->id() ? 'blue' : 'gray' }}-100 rounded-xl px-4 py-2 max-w-md">
                        <p class="text-sm">{{ $msg->message }}</p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $msg->user->name ?? 'Unknown' }} • {{ $msg->created_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
        <form wire:submit.prevent="send" class="flex gap-2 mt-2">
            <input type="text" wire:model.defer="message" placeholder="Tulis pesan..." class="flex-1 border px-3 py-2 rounded-md shadow-sm" />
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Kirim</button>
        </form>


    </x-filament::section>
