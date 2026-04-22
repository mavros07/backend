@push('body-end')
  <input type="hidden" id="page-editor-app-url" value="{{ rtrim(url('/'), '/') }}" />

  <div id="media-modal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/70 p-4">
    <div class="mx-auto flex h-full max-h-[90vh] w-full max-w-[min(72rem,92vw)] flex-col overflow-hidden rounded-lg bg-white shadow-2xl">
      <div class="flex shrink-0 items-center justify-between border-b border-gray-200 px-4 py-3">
        <h3 class="text-sm font-semibold text-gray-900">Select Media</h3>
        <button type="button" class="js-media-modal-close text-gray-500 hover:text-gray-900" aria-label="Close">✕</button>
      </div>
      <div class="shrink-0 border-b border-gray-200 p-4">
        <input id="media-search" type="search" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Search media..."/>
      </div>
      <div class="shrink-0 border-b border-gray-200 bg-gray-50 p-4">
        <form id="media-upload-form" method="post" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" class="flex flex-col gap-2 sm:flex-row sm:items-center">
          @csrf
          <input id="media-upload-input" type="file" name="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="block w-full text-sm text-gray-700" />
          <button type="submit" class="whitespace-nowrap rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">Upload</button>
        </form>
      </div>
      <div id="media-grid" class="min-h-0 flex-1 overflow-auto p-4 grid grid-cols-2 gap-3 md:grid-cols-4"></div>
      <div class="shrink-0 border-t border-gray-200 px-4 py-3 text-right">
        <button type="button" class="js-media-modal-close rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Close</button>
      </div>
    </div>
  </div>

  <input type="hidden" id="media-list-url" value="{{ route('admin.media.list') }}" />

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const appUrlEl = document.getElementById('page-editor-app-url');
      const mediaListUrl = document.getElementById('media-list-url')?.value;
      const mediaUploadForm = document.getElementById('media-upload-form');
      const mediaSearch = document.getElementById('media-search');
      if (!appUrlEl || !mediaListUrl || !mediaUploadForm || !mediaSearch) return;

      const appUrl = appUrlEl.value;

      function publicUrlFromPath(path) {
        const p = (path || '').trim();
        if (!p) return '';
        if (/^https?:\/\//i.test(p)) return p;
        const clean = p.replace(/^\/+/, '');
        return `${appUrl}/${clean}`;
      }

      function syncMediaPathInput(input) {
        if (!input || !input.classList.contains('js-media-path-input')) return;
        const p = (input.value || '').trim();
        const readout = document.querySelector(`[data-readout-for="${input.id}"]`);
        if (readout) {
          readout.textContent = p || (readout.dataset.emptyLabel || '—');
        }
        const manual = document.getElementById(`${input.id}-manual`);
        if (manual && manual.value !== input.value) {
          manual.value = input.value;
        }
        const wrap = document.querySelector(`[data-media-preview-wrap="${input.id}"]`);
        if (!wrap) return;
        const img = wrap.querySelector('.js-media-preview-img');
        const ph = wrap.querySelector('.js-media-preview-placeholder');
        const err = wrap.querySelector('.js-media-preview-error');
        if (!img || !ph) return;
        err?.classList.add('hidden');
        if (!p) {
          img.removeAttribute('src');
          img.classList.add('hidden');
          ph.classList.remove('hidden');
          return;
        }
        ph.classList.add('hidden');
        img.classList.remove('hidden');
        img.onload = () => { err?.classList.add('hidden'); };
        img.onerror = () => {
          img.classList.add('hidden');
          ph.classList.add('hidden');
          err?.classList.remove('hidden');
        };
        img.src = publicUrlFromPath(p);
      }

      let mediaTargetInputId = null;
      let mediaItems = [];
      function updateMediaModalSizing() {
        const modal = document.getElementById('media-modal');
        const panel = modal?.querySelector(':scope > div');
        if (!modal || !panel) return;
        const desktop = window.matchMedia('(min-width: 1024px)').matches;
        if (!desktop) {
          panel.style.maxWidth = 'min(72rem, 92vw)';
          return;
        }
        const sidebar = document.querySelector('.admin-sidebar');
        const sidebarWidth = sidebar ? Math.max(0, Math.round(sidebar.getBoundingClientRect().width || 0)) : 0;
        const usable = Math.max(480, window.innerWidth - sidebarWidth - 24);
        panel.style.maxWidth = `min(72rem, ${usable}px)`;
      }
      function closeMediaModal() {
        const modal = document.getElementById('media-modal');
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
      }
      window.closeMediaModal = closeMediaModal;
      function renderMediaGrid(filter = '') {
        const grid = document.getElementById('media-grid');
        if (!grid) return;
        const q = (filter || '').toLowerCase();
        const list = mediaItems.filter((m) => !q || m.name.toLowerCase().includes(q));
        grid.innerHTML = list.map((m) => `
          <button type="button" class="rounded-lg border border-gray-200 p-2 text-left shadow-sm hover:border-indigo-300 hover:bg-indigo-50/40" data-path="${m.path}">
            <img src="${m.url}" alt="" class="h-24 w-full rounded-md object-cover" />
            <p class="mt-2 truncate text-xs text-gray-700" title="${m.name}">${m.name}</p>
          </button>
        `).join('');
        grid.querySelectorAll('button[data-path]').forEach((btn) => {
          btn.addEventListener('click', () => {
            if (!mediaTargetInputId) return;
            const input = document.getElementById(mediaTargetInputId);
            if (input) {
              input.value = btn.getAttribute('data-path');
              input.dispatchEvent(new Event('input', { bubbles: true }));
            }
            closeMediaModal();
          });
        });
      }
      async function openMediaModal(targetInputId) {
        mediaTargetInputId = targetInputId;
        const modal = document.getElementById('media-modal');
        if (!modal) return;
        updateMediaModalSizing();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        try {
          const res = await fetch(mediaListUrl, { credentials: 'same-origin' });
          const data = await res.json();
          mediaItems = data.media || [];
          renderMediaGrid(mediaSearch.value);
        } catch (_) {
          mediaItems = [];
          renderMediaGrid('');
        }
      }
      mediaSearch.addEventListener('input', (e) => {
        renderMediaGrid(e.target.value);
      });
      document.querySelectorAll('.js-media-picker').forEach((btn) => {
        btn.addEventListener('click', () => {
          openMediaModal(btn.getAttribute('data-media-target'));
        });
      });
      document.querySelectorAll('.js-media-modal-close').forEach((btn) => {
        btn.addEventListener('click', closeMediaModal);
      });
      document.getElementById('media-modal')?.addEventListener('click', (e) => {
        if (e.target?.id === 'media-modal') closeMediaModal();
      });
      window.addEventListener('resize', () => {
        const modal = document.getElementById('media-modal');
        if (modal && !modal.classList.contains('hidden')) updateMediaModalSizing();
      });

      document.querySelectorAll('.js-media-path-input').forEach((input) => {
        input.addEventListener('input', () => syncMediaPathInput(input));
        syncMediaPathInput(input);
      });

      document.querySelectorAll('.js-media-manual-input').forEach((manual) => {
        manual.addEventListener('input', () => {
          const baseId = manual.id.replace(/-manual$/, '');
          const hidden = document.getElementById(baseId);
          if (!hidden) return;
          hidden.value = manual.value;
          hidden.dispatchEvent(new Event('input', { bubbles: true }));
        });
      });

      document.querySelectorAll('.js-media-copy-path').forEach((btn) => {
        const defaultLabel = btn.dataset.labelCopy || 'Copy';
        btn.addEventListener('click', async () => {
          const id = btn.getAttribute('data-copy-from');
          const el = id ? document.getElementById(id) : null;
          const v = (el?.value || '').trim();
          if (!v) return;
          try {
            await navigator.clipboard.writeText(v);
            const copied = btn.dataset.labelCopied || 'Copied';
            btn.textContent = copied;
            setTimeout(() => {
              btn.textContent = defaultLabel;
            }, 1800);
          } catch (_) {
            // Clipboard may be blocked; ignore.
          }
        });
      });

      document.querySelectorAll('.js-media-clear').forEach((btn) => {
        btn.addEventListener('click', () => {
          const id = btn.getAttribute('data-clear-target');
          const input = id ? document.getElementById(id) : null;
          if (input) {
            input.value = '';
            input.dispatchEvent(new Event('input', { bubbles: true }));
          }
        });
      });

      mediaUploadForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const input = document.getElementById('media-upload-input');
        if (!input.files || !input.files.length) return;
        const formData = new FormData(mediaUploadForm);
        const token = mediaUploadForm.querySelector('input[name="_token"]').value;
        try {
          const res = await fetch(mediaUploadForm.action, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
            body: formData,
          });
          if (!res.ok) return;
          input.value = '';
          await openMediaModal(mediaTargetInputId);
        } catch (_) {
          // Keep modal open even if upload fails.
        }
      });
    });
  </script>
@endpush

@php
  $sectionFieldGroups = [];
  foreach ($pageInfo['fields'] as $f) {
    $g = $f['group'] ?? __('General');
    $sectionFieldGroups[$g][] = $f;
  }
@endphp

<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Page') }}: {{ $pageInfo['label'] }}
      </h2>
      <a href="{{ route('admin.pages.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
        {{ __('All pages') }} →
      </a>
    </div>
  </x-slot>

  <div class="w-full pb-10">
    @if (session('status'))
      <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 shadow-sm">
        {{ session('status') }}
      </div>
    @endif

    @if ($errors->any())
      <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 shadow-sm">
        <ul class="list-disc space-y-1 pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="post" action="{{ route('admin.pages.update', ['slug' => $slug]) }}" class="space-y-6">
      @csrf
      @method('PUT')

      <div class="space-y-6">
        <div class="space-y-6">
          <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50/80 px-5 py-4">
              <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">{{ __('Page & SEO') }}</h3>
              <p class="mt-1 text-sm text-gray-600">{{ __('Title and description used in the browser tab and search snippets.') }}</p>
            </div>
            <div class="space-y-5 p-5">
              <div>
                <x-input-label for="page_title" value="{{ __('Page title') }}" />
                <x-text-input
                  id="page_title"
                  name="title"
                  type="text"
                  class="mt-1 block w-full"
                  value="{{ old('title', $page->title) }}"
                  required
                />
              </div>
              <div>
                <x-input-label for="meta_description" value="{{ __('Meta description') }}" />
                <textarea
                  id="meta_description"
                  name="meta_description"
                  rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >{{ old('meta_description', $page->meta_description) }}</textarea>
                <p class="mt-1.5 text-xs text-gray-500">{{ __('Optional. Roughly one or two sentences.') }}</p>
              </div>
            </div>
          </div>

          <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50/80 px-5 py-4">
              <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">{{ __('Custom HTML') }}</h3>
              <p class="mt-1 text-sm text-gray-600">{{ __('Optional extra markup for this page template.') }}</p>
            </div>
            <div class="p-5">
              <x-input-label for="content_html" value="{{ __('Content HTML') }}" />
              <textarea
                id="content_html"
                name="content_html"
                rows="12"
                class="mt-1 block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              >{{ old('content_html', $page->content_html) }}</textarea>
            </div>
          </div>
        </div>
      </div>

      @if (count($pageInfo['fields']) > 0)
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
          <div class="border-b border-gray-100 bg-gray-50/80 px-5 py-4">
            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500">{{ __('Section content') }}</h3>
            <p class="mt-1 text-sm text-gray-600">
              {{ __('Copy and images for page sections. Lists and cards that pull from inventory stay dynamic.') }}
            </p>
          </div>
          <div class="space-y-8 bg-slate-50/60 p-5">
            @foreach ($sectionFieldGroups as $groupTitle => $fieldsInGroup)
              <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <h4 class="border-b border-gray-100 pb-3 text-sm font-semibold text-gray-900">{{ $groupTitle }}</h4>
                {{-- Short text fields share a row on md+ (cf. form-row); images span full width with select → dashed preview → optional path --}}
                <div class="mt-5 grid gap-6 md:grid-cols-2">
                  @foreach ($fieldsInGroup as $field)
                    @php
                      $value = old('sections.'.$field['name'], $sectionValues[$field['name']] ?? $field['default']);
                      $inputId = 'section-'.$field['name'];
                    @endphp
                    @if ($field['type'] === 'image')
                      <div class="js-media-field rounded-lg border border-gray-100 bg-slate-50/50 p-4 md:col-span-2">
                        <span class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</span>
                        <p class="mt-1 text-xs text-gray-500">{{ __('Use the library to pick a file; the preview updates automatically. The path is stored on the server when you save the page.') }}</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                          <button
                            type="button"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 js-media-picker"
                            data-media-target="{{ $inputId }}"
                          >{{ __('Select image') }}</button>
                          <button
                            type="button"
                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-600 shadow-sm hover:bg-gray-50 js-media-clear"
                            data-clear-target="{{ $inputId }}"
                          >{{ __('Clear') }}</button>
                        </div>
                        <input
                          type="hidden"
                          name="sections[{{ $field['name'] }}]"
                          id="{{ $inputId }}"
                          value="{{ $value }}"
                          class="js-media-path-input"
                          autocomplete="off"
                        />
                        <div
                          class="mt-3 rounded-md border border-dashed border-gray-300 bg-stone-50 p-3 shadow-inner"
                          data-media-preview-wrap="{{ $inputId }}"
                        >
                          <div class="relative flex min-h-[10rem] max-h-[20rem] w-full items-center justify-center overflow-hidden rounded-md bg-white">
                            <img
                              src=""
                              alt=""
                              class="js-media-preview-img hidden max-h-[18rem] w-full object-contain"
                            />
                            <div class="js-media-preview-placeholder pointer-events-none absolute inset-0 flex flex-col items-center justify-center gap-1 bg-gradient-to-br from-gray-50 to-gray-100 p-4 text-center">
                              <svg class="h-10 w-10 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" /></svg>
                              <span class="text-xs font-medium text-gray-400">{{ __('No preview yet — select an image') }}</span>
                            </div>
                            <div class="js-media-preview-error absolute inset-0 hidden flex-col items-center justify-center gap-1 bg-amber-50/95 p-4 text-center">
                              <span class="text-xs font-medium text-amber-900">{{ __('Could not load preview') }}</span>
                              <span class="text-[11px] text-amber-800">{{ __('Confirm the file exists under public/ or upload it via Media.') }}</span>
                            </div>
                          </div>
                        </div>
                        <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:flex-wrap sm:items-center sm:gap-x-4 sm:gap-y-1">
                          <div class="min-w-0 flex-1">
                            <span class="text-xs font-medium text-gray-500">{{ __('Stored path') }}</span>
                            <code
                              class="js-media-path-readout mt-0.5 block w-full max-w-full break-all rounded bg-white px-2 py-1.5 text-left text-[11px] leading-snug text-gray-800 ring-1 ring-gray-200"
                              data-readout-for="{{ $inputId }}"
                              data-empty-label="{{ __('No file selected') }}"
                            ></code>
                          </div>
                          <button
                            type="button"
                            class="js-media-copy-path shrink-0 self-start rounded-md border border-gray-300 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 shadow-sm hover:bg-gray-50 sm:self-center"
                            data-copy-from="{{ $inputId }}"
                            data-label-copy="{{ __('Copy path') }}"
                            data-label-copied="{{ __('Copied') }}"
                          >{{ __('Copy path') }}</button>
                        </div>
                        <details class="mt-3 rounded-md border border-gray-200 bg-white">
                          <summary class="cursor-pointer select-none px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('Paste or edit path') }}</summary>
                          <div class="border-t border-gray-100 p-3">
                            <label for="{{ $inputId }}-manual" class="sr-only">{{ __('Image path') }}</label>
                            <input
                              type="text"
                              id="{{ $inputId }}-manual"
                              value="{{ $value }}"
                              class="js-media-manual-input block w-full rounded-md border-gray-300 font-mono text-xs shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                              autocomplete="off"
                            />
                            <p class="mt-2 text-xs text-gray-500">{{ __('Relative to the site root, e.g.') }} <code class="rounded bg-gray-100 px-1 py-0.5">asset/images/media/photo.jpg</code></p>
                          </div>
                        </details>
                      </div>
                    @elseif ($field['type'] === 'textarea')
                      <div class="md:col-span-2">
                        <x-input-label :for="$inputId" :value="$field['label']" />
                        <textarea
                          id="{{ $inputId }}"
                          name="sections[{{ $field['name'] }}]"
                          rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >{{ $value }}</textarea>
                      </div>
                    @else
                      <div>
                        <x-input-label :for="$inputId" :value="$field['label']" />
                        <x-text-input
                          id="{{ $inputId }}"
                          name="sections[{{ $field['name'] }}]"
                          type="text"
                          class="mt-1 block w-full"
                          value="{{ $value }}"
                        />
                      </div>
                    @endif
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <div class="sticky bottom-4 z-20 rounded-xl border border-gray-200 bg-white/95 p-4 shadow-lg backdrop-blur sm:flex sm:items-center sm:justify-between">
        <label class="flex cursor-pointer items-start gap-3">
          <input type="hidden" name="is_active" value="0" />
          <input
            type="checkbox"
            name="is_active"
            value="1"
            class="mt-0.5 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
            {{ old('is_active', (int) $page->is_active) ? 'checked' : '' }}
          />
          <span>
            <span class="block text-sm font-medium text-gray-900">{{ __('Page is active') }}</span>
            <span class="mt-0.5 block text-xs text-gray-500">{{ __('Inactive pages return 404 on the public site.') }}</span>
          </span>
        </label>
        <div class="mt-3 flex items-center justify-end gap-3 sm:mt-0">
          <a href="{{ route('admin.pages.index') }}" class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('All pages') }}</a>
          <button type="submit" class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            {{ __('Save page') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</x-app-layout>
