<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Listing options') }}
    </h2>
  </x-slot>

  <div class="w-full">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-sm text-gray-600 mb-6">
        {{ __('Define controlled values for make, model, condition, and other listing fields. Empty categories still allow free text on listing forms until you add options.') }}
      </p>

      @if ($categories->isEmpty())
        <p class="text-sm text-amber-800">{{ __('No categories found. Run migrations to create listing option tables.') }}</p>
      @else
        <ul class="divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
          @foreach ($categories as $cat)
            <li class="flex flex-wrap items-center justify-between gap-3 px-4 py-3 hover:bg-gray-50">
              <div>
                <span class="font-medium text-gray-900">{{ $cat->label }}</span>
                <span class="text-xs text-gray-500 ml-2">{{ $cat->slug }}</span>
              </div>
              <a href="{{ route('admin.listing-options.show', $cat) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                {{ __('Manage') }} →
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</x-app-layout>
