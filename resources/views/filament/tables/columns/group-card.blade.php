<a href="{{ route('filament.admin.resources.groups.edit', $getRecord()) }}" class="block">
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $getRecord()->name }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $getRecord()->description }}</p>
        <div class="text-xs text-gray-400">Dibuat pada {{ $getRecord()->created_at->format('d M Y') }}</div>
    </div>
</a>