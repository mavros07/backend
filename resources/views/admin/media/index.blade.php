<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Media Library') }}
    </h2>
  </x-slot>

  <div class="w-full space-y-6">
      @if (session('status'))
        <div class="rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700 text-sm">
          {{ session('status') }}
        </div>
      @endif

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <form method="get" action="{{ route('admin.media.index') }}" class="flex gap-2">
          <input type="search" name="q" value="{{ $query }}" class="flex-1 rounded border-gray-300" placeholder="Search media file name..." />
          <button class="px-4 py-2 rounded bg-indigo-600 text-white text-sm">Search</button>
        </form>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <form method="post" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" class="flex items-center gap-3">
          @csrf
          <input type="file" name="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="block w-full text-sm text-gray-700" required />
          <button class="px-4 py-2 rounded bg-indigo-600 text-white text-sm whitespace-nowrap">Upload</button>
        </form>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <p class="text-sm text-gray-600 mb-4">All uploaded images used by editors and pages.</p>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
          @forelse ($items as $item)
            <div class="border rounded p-2">
              <img src="{{ $item['url'] }}" alt="{{ $item['name'] }}" class="h-24 w-full object-cover rounded" />
              <p class="mt-2 text-xs text-gray-800 truncate" title="{{ $item['name'] }}">{{ $item['name'] }}</p>
              <p class="text-[11px] text-gray-500">{{ number_format($item['size'] / 1024, 1) }} KB</p>
            </div>
          @empty
            <p class="text-sm text-gray-500 col-span-full">No media files found.</p>
          @endforelse
        </div>
      </div>
  </div>
</x-app-layout>

