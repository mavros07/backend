<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-wrap items-center justify-between gap-3">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Listing options') }}: {{ $category->label }}
      </h2>
      <a href="{{ route('admin.listing-options.index') }}" class="text-sm text-indigo-600 hover:underline">{{ __('All categories') }}</a>
    </div>
  </x-slot>

  <div class="w-full space-y-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
      @if ($errors->any())
        <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-800">
          <ul class="list-disc pl-4">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif

      @if (session('status'))
        <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800">{{ session('status') }}</div>
      @endif

      <form method="post" action="{{ route('admin.listing-options.store', $category) }}" class="mb-8 space-y-4 rounded-lg border border-gray-200 p-4">
        @csrf
        <h3 class="text-sm font-semibold text-gray-900">{{ __('Add option') }}</h3>
        <div class="grid gap-4 sm:grid-cols-2">
          <div class="sm:col-span-2">
            <x-input-label for="value" :value="__('Value')" />
            <x-text-input id="value" name="value" type="text" class="mt-1 block w-full" required value="{{ old('value') }}" />
          </div>
          @if ($category->slug === 'model')
            <div class="sm:col-span-2">
              <x-input-label for="parent_id" :value="__('Parent make')" />
              <select id="parent_id" name="parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">{{ __('Select make') }}</option>
                @foreach ($makeOptions as $m)
                  <option value="{{ $m->id }}" @selected((string) old('parent_id') === (string) $m->id)>{{ $m->value }}</option>
                @endforeach
              </select>
            </div>
          @endif
          <div class="flex items-center gap-2">
            <input id="is_active" name="is_active" type="checkbox" value="1" class="rounded border-gray-300 text-indigo-600" @checked(old('is_active', true)) />
            <x-input-label for="is_active" :value="__('Active')" class="!mb-0" />
          </div>
        </div>
        <x-primary-button type="submit">{{ __('Add') }}</x-primary-button>
      </form>

      @if ($options->isEmpty())
        <p class="text-sm text-gray-600">{{ __('No options yet. Add values above.') }}</p>
      @else
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
          <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-3 py-2 text-left font-medium text-gray-700">{{ __('Value') }}</th>
                @if ($category->slug === 'model')
                  <th class="px-3 py-2 text-left font-medium text-gray-700">{{ __('Make') }}</th>
                @endif
                <th class="px-3 py-2 text-left font-medium text-gray-700">{{ __('Order') }}</th>
                <th class="px-3 py-2 text-left font-medium text-gray-700">{{ __('Active') }}</th>
                <th class="px-3 py-2 text-right font-medium text-gray-700">{{ __('Actions') }}</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              @foreach ($options as $option)
                <tr>
                  <td class="px-3 py-2 align-top">
                    <form method="post" action="{{ route('admin.listing-options.update', [$category, $option]) }}" class="flex flex-wrap items-end gap-2">
                      @csrf
                      @method('PUT')
                      <input type="text" name="value" value="{{ $option->value }}" class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500 min-w-[10rem]" required />
                      <label class="inline-flex items-center gap-1 text-xs text-gray-600">
                        <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600" @checked($option->is_active) />
                        {{ __('Active') }}
                      </label>
                      <x-secondary-button type="submit" class="!py-1 !text-xs">{{ __('Save') }}</x-secondary-button>
                    </form>
                  </td>
                  @if ($category->slug === 'model')
                    <td class="px-3 py-2 text-gray-700">{{ $option->parent?->value ?? '—' }}</td>
                  @endif
                  <td class="px-3 py-2 whitespace-nowrap">
                    <div class="flex flex-col gap-1">
                      <form method="post" action="{{ route('admin.listing-options.move', [$category, $option]) }}" class="inline">
                        @csrf
                        <input type="hidden" name="direction" value="up" />
                        <button type="submit" class="text-xs text-gray-600 hover:text-indigo-600">{{ __('Up') }}</button>
                      </form>
                      <form method="post" action="{{ route('admin.listing-options.move', [$category, $option]) }}" class="inline">
                        @csrf
                        <input type="hidden" name="direction" value="down" />
                        <button type="submit" class="text-xs text-gray-600 hover:text-indigo-600">{{ __('Down') }}</button>
                      </form>
                    </div>
                  </td>
                  <td class="px-3 py-2">{{ $option->is_active ? __('Yes') : __('No') }}</td>
                  <td class="px-3 py-2 text-right align-top">
                    <form method="post" action="{{ route('admin.listing-options.destroy', [$category, $option]) }}" onsubmit="return confirm(@json(__('Delete this option?')))">
                      @csrf
                      @method('DELETE')
                      <x-danger-button type="submit" class="!py-1 !text-xs">{{ __('Delete') }}</x-danger-button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</x-app-layout>
