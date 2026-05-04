<x-app-layout>
  <x-slot name="header">
    <div>
      <div class="text-[11px] font-bold uppercase tracking-[0.18em] text-zinc-500">{{ __('Admin') }}</div>
      <div class="text-xl font-bold tracking-tight text-zinc-900">{{ __('Listing options') }}</div>
    </div>
  </x-slot>

  <div class="space-y-6">
    <div class="rounded-2xl border border-zinc-200/90 bg-white p-6 shadow-sm ring-1 ring-black/[0.02]">
      <p class="text-sm leading-relaxed text-zinc-600">
        {{ __('Define controlled values for make, model, condition, and other listing fields. Empty categories still allow free text on listing forms until you add options.') }}
      </p>

      @if ($categories->isEmpty())
        <p class="mt-4 text-sm font-medium text-amber-800">{{ __('No categories found. Run migrations to create listing option tables.') }}</p>
      @else
        <ul class="mt-6 divide-y divide-zinc-200 rounded-xl border border-zinc-200/90 bg-zinc-50/40">
          @foreach ($categories as $cat)
            <li class="flex flex-wrap items-center justify-between gap-3 px-4 py-3.5 transition hover:bg-white">
              <div class="min-w-0">
                <span class="font-semibold text-zinc-900">{{ $cat->label }}</span>
                <span class="ml-2 rounded-md bg-zinc-200/80 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-zinc-600">{{ $cat->slug }}</span>
              </div>
              <a
                href="{{ route('admin.listing-options.show', $cat) }}"
                class="inline-flex shrink-0 items-center rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-xs font-semibold text-zinc-800 shadow-sm transition hover:border-amber-300/70 hover:bg-amber-50/50 hover:text-zinc-900"
              >
                {{ __('Manage') }}
                <span class="ml-1 text-zinc-400" aria-hidden="true">→</span>
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
</x-app-layout>
