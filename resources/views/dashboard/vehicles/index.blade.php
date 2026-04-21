@php
  $isAdminList = $isAdminList ?? false;
  $statusFilter = $statusFilter ?? '';
@endphp
<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
      <h2 class="text-xl font-semibold text-slate-800">
        {{ $isAdminList ? __('All listings') : __('My vehicles') }}
      </h2>
      <a
        href="{{ route('dashboard.vehicles.create') }}"
        class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-slate-900 shadow hover:bg-amber-400"
      >
        {{ __('New listing') }}
      </a>
    </div>
  </x-slot>

  <div
    class="p-4 sm:p-6 lg:p-8"
    x-data="{
      actionsOpen: false,
      row: null,
      rejectExpanded: false,
      rejectDraft: '',
      openActions(payload) {
        this.row = payload;
        this.rejectDraft = payload.rejectionReason || '';
        this.rejectExpanded = false;
        this.actionsOpen = true;
        document.body.classList.add('overflow-hidden');
      },
      closeActions() {
        this.actionsOpen = false;
        this.row = null;
        this.rejectExpanded = false;
        this.rejectDraft = '';
        document.body.classList.remove('overflow-hidden');
      },
    }"
    @keydown.escape.window="closeActions()"
  >
    @if($isAdminList && $stats)
      <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
          <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Total on site') }}</div>
          <div class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['total'] }}</div>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
          <div class="text-xs font-semibold uppercase tracking-wide text-amber-800">{{ __('Pending review') }}</div>
          <div class="mt-2 text-3xl font-bold text-amber-900">{{ $stats['pending'] }}</div>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5 shadow-sm">
          <div class="text-xs font-semibold uppercase tracking-wide text-emerald-800">{{ __('Approved live') }}</div>
          <div class="mt-2 text-3xl font-bold text-emerald-900">{{ $stats['approved'] }}</div>
        </div>
      </div>

      <div class="mb-4 flex flex-wrap gap-2">
        <span class="self-center text-sm font-medium text-slate-600">{{ __('Filter') }}:</span>
        <a href="{{ route('dashboard.vehicles.index') }}" class="rounded-full px-3 py-1 text-sm font-medium {{ $statusFilter === '' ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50' }}">{{ __('All') }}</a>
        @foreach (['pending' => __('Pending'), 'approved' => __('Approved'), 'draft' => __('Draft'), 'rejected' => __('Rejected')] as $st => $label)
          <a href="{{ route('dashboard.vehicles.index', ['status' => $st]) }}" class="rounded-full px-3 py-1 text-sm font-medium {{ $statusFilter === $st ? 'bg-slate-900 text-white' : 'bg-white text-slate-700 ring-1 ring-slate-200 hover:bg-slate-50' }}">{{ $label }}</a>
        @endforeach
      </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
      <div class="p-4 sm:p-6">
        @if(session('status'))
          <div class="mb-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm text-emerald-800 ring-1 ring-emerald-100">
            {{ session('status') }}
          </div>
        @endif

        @if($vehicles->total() === 0)
          <p class="text-slate-600">{{ $isAdminList ? __('No vehicles match this filter.') : __('You have no listings yet.') }}</p>
        @else
          <div class="-mx-4 overflow-x-auto sm:mx-0">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
              <thead>
                <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                  <th class="whitespace-nowrap px-4 py-3">{{ __('Listing') }}</th>
                  @if($isAdminList)
                    <th class="whitespace-nowrap px-4 py-3">{{ __('Posted by') }}</th>
                    <th class="whitespace-nowrap px-4 py-3">{{ __('Submitted') }}</th>
                  @endif
                  <th class="whitespace-nowrap px-4 py-3">{{ __('Status') }}</th>
                  <th class="whitespace-nowrap px-4 py-3 text-right">{{ __('Actions') }}</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-100">
                @foreach($vehicles as $vehicle)
                  @php
                    $owner = $vehicle->user;
                    $isStaffListing = $owner && $owner->hasRole('admin');
                    $modalRow = [
                      'id' => $vehicle->id,
                      'title' => $vehicle->title,
                      'status' => $vehicle->status,
                      'slug' => $vehicle->slug,
                      'viewUrl' => $vehicle->status === 'approved' ? route('inventory.show', ['slug' => $vehicle->slug]) : null,
                      'editUrl' => route('dashboard.vehicles.edit', $vehicle),
                      'destroyUrl' => route('dashboard.vehicles.destroy', $vehicle),
                      'approveUrl' => $isAdminList ? route('admin.vehicles.approve', $vehicle) : null,
                      'rejectUrl' => $isAdminList ? route('admin.vehicles.reject', $vehicle) : null,
                      'canApprove' => $isAdminList && in_array($vehicle->status, ['pending', 'draft', 'rejected'], true),
                      'canReject' => $isAdminList && $vehicle->status !== 'rejected',
                      'rejectionReason' => old('rejection_reason', $vehicle->rejection_reason ?? ''),
                    ];
                  @endphp
                  <tr class="align-top">
                    <td class="px-4 py-3">
                      <div class="font-semibold text-slate-900">{{ $vehicle->title }}</div>
                      <div class="text-slate-500">{{ $vehicle->year }} {{ $vehicle->make }} {{ $vehicle->model }}</div>
                    </td>
                    @if($isAdminList)
                      <td class="px-4 py-3 text-slate-700">
                        <div class="font-medium">{{ $owner?->name ?? '—' }}</div>
                        <div class="text-xs text-slate-500">{{ $owner?->email }}</div>
                        <div class="mt-1">
                          @if($isStaffListing)
                            <span class="inline-flex rounded-full bg-violet-100 px-2 py-0.5 text-xs font-medium text-violet-800">{{ __('Staff listing') }}</span>
                          @else
                            <span class="inline-flex rounded-full bg-sky-100 px-2 py-0.5 text-xs font-medium text-sky-800">{{ __('Vendor listing') }}</span>
                          @endif
                        </div>
                      </td>
                      <td class="whitespace-nowrap px-4 py-3 text-slate-600">{{ $vehicle->submitted_at?->format('M j, Y g:i a') ?? '—' }}</td>
                    @endif
                    <td class="px-4 py-3">
                      <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold
                        @if($vehicle->status === 'approved') bg-emerald-100 text-emerald-800
                        @elseif($vehicle->status === 'pending') bg-amber-100 text-amber-900
                        @elseif($vehicle->status === 'rejected') bg-rose-100 text-rose-800
                        @else bg-slate-100 text-slate-700
                        @endif
                      ">{{ strtoupper($vehicle->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                      <button
                        type="button"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900"
                        title="{{ __('Actions') }}"
                        @click="openActions({{ \Illuminate\Support\Js::from($modalRow) }})"
                        aria-label="{{ __('Actions') }}"
                      >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg>
                      </button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          {{-- Actions modal (ellipsis menu pattern; actions listed inside panel) --}}
          <div
            class="fixed inset-0 z-[300] flex items-end justify-center sm:items-center"
            x-show="actionsOpen"
            x-cloak
            x-transition.opacity
            aria-modal="true"
            role="dialog"
          >
            <div class="absolute inset-0 bg-slate-900/50" @click="closeActions()" aria-hidden="true"></div>
            <div
              class="relative z-10 mb-0 w-full max-w-md rounded-t-2xl border border-slate-200 bg-white shadow-2xl sm:m-4 sm:rounded-2xl"
              x-show="actionsOpen"
              x-transition
              @click.stop
            >
              <div class="flex items-start justify-between gap-3 border-b border-slate-100 px-5 py-4">
                <div class="min-w-0">
                  <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Listing') }}</div>
                  <h3 class="mt-1 truncate text-lg font-semibold text-slate-900" x-text="row?.title"></h3>
                  <div class="mt-1 text-xs font-medium uppercase text-slate-500" x-text="row?.status"></div>
                </div>
                <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900" @click="closeActions()" aria-label="{{ __('Close') }}">
                  <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
              </div>
              <div class="max-h-[min(70vh,28rem)] space-y-1 overflow-y-auto px-3 py-4">
                <template x-if="row && row.viewUrl">
                  <a x-bind:href="row.viewUrl" target="_blank" rel="noopener noreferrer" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-left text-sm font-medium text-slate-800 hover:bg-slate-50" @click="closeActions()">{{ __('View live listing') }}</a>
                </template>
                <a x-bind:href="row && row.editUrl" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-left text-sm font-medium text-amber-800 hover:bg-amber-50" @click="closeActions()">{{ __('Edit') }}</a>

                <template x-if="row && row.canApprove">
                  <form method="post" x-bind:action="row.approveUrl">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-left text-sm font-medium text-emerald-800 hover:bg-emerald-50">{{ __('Approve') }}</button>
                  </form>
                </template>

                <template x-if="row && row.canReject">
                  <div class="rounded-lg border border-slate-100 bg-slate-50/80">
                    <button type="button" class="flex w-full items-center justify-between gap-2 px-3 py-3 text-left text-sm font-medium text-rose-800 hover:bg-rose-50/80" @click="rejectExpanded = !rejectExpanded">
                      <span>{{ __('Reject…') }}</span>
                      <svg class="h-4 w-4 shrink-0 transition-transform" :class="rejectExpanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <form x-show="rejectExpanded" method="post" x-bind:action="row.rejectUrl" class="space-y-3 border-t border-slate-100 px-3 pb-3 pt-2" x-cloak>
                      @csrf
                      <label class="block text-xs font-medium text-slate-600">{{ __('Reason (optional)') }}</label>
                      <textarea name="rejection_reason" rows="3" x-model="rejectDraft" class="w-full rounded-md border border-slate-300 text-sm shadow-sm focus:border-rose-400 focus:ring-rose-400" placeholder="{{ __('Explain to the vendor…') }}"></textarea>
                      <button type="submit" class="w-full rounded-md bg-rose-600 px-3 py-2 text-sm font-semibold text-white hover:bg-rose-500">{{ __('Reject listing') }}</button>
                    </form>
                  </div>
                </template>

                <form method="post" x-bind:action="row && row.destroyUrl" class="border-t border-slate-100 pt-2" onsubmit="return confirm({{ json_encode(__('Delete this listing permanently?')) }});">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-3 text-left text-sm font-medium text-rose-900 hover:bg-rose-50">{{ __('Delete') }}</button>
                </form>
              </div>
            </div>
          </div>

          <div class="mt-6 border-t border-slate-100 pt-4">
            {{ $vehicles->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>
