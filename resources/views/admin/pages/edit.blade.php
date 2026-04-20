<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Page') }}: {{ $pageInfo['label'] }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        @if (session('status'))
          <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700 text-sm">
            {{ session('status') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 rounded border border-red-200 bg-red-50 px-4 py-3 text-red-700 text-sm">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="post" action="{{ route('admin.pages.update', ['slug' => $slug]) }}" class="space-y-6">
          @csrf
          @method('PUT')

          <div>
            <label class="block text-sm font-medium text-gray-700">Page Title</label>
            <input
              type="text"
              name="title"
              value="{{ old('title', $page->title) }}"
              class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              required
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Meta Description</label>
            <textarea
              name="meta_description"
              rows="3"
              class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >{{ old('meta_description', $page->meta_description) }}</textarea>
          </div>

          <div class="rounded border border-gray-200 p-4">
            <label class="inline-flex items-center gap-2">
              <input type="hidden" name="is_active" value="0" />
              <input
                type="checkbox"
                name="is_active"
                value="1"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                {{ old('is_active', (int) $page->is_active) ? 'checked' : '' }}
              />
              <span class="text-sm text-gray-800 font-medium">Page is active</span>
            </label>
            <p class="mt-1 text-xs text-gray-500">Inactive pages return 404 on the public website until re-enabled.</p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Content HTML</label>
            <textarea
              name="content_html"
              rows="14"
              class="mt-1 block w-full rounded border-gray-300 shadow-sm font-mono text-sm focus:border-indigo-500 focus:ring-indigo-500"
            >{{ old('content_html', $page->content_html) }}</textarea>
            <p class="mt-2 text-xs text-gray-500">
              HTML is allowed here for flexible page sections.
            </p>
          </div>

          <div class="rounded border border-gray-200 p-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">Dynamic Section Settings</h3>
            <p class="text-xs text-gray-500 mb-4">
              These settings control section text/images only. Dynamic lists (recent cars, inventory cards, compare items, listing details) come from listing records and are not editable here.
            </p>
            <div class="space-y-4">
              @foreach ($pageInfo['fields'] as $field)
                @php
                  $value = old('sections.'.$field['name'], $sectionValues[$field['name']] ?? $field['default']);
                @endphp
                <div>
                  <label class="block text-sm font-medium text-gray-700">{{ $field['label'] }}</label>
                  @if ($field['type'] === 'textarea')
                    <textarea
                      name="sections[{{ $field['name'] }}]"
                      rows="3"
                      class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >{{ $value }}</textarea>
                  @elseif ($field['type'] === 'image')
                    <div class="mt-1 flex gap-2">
                      <input
                        type="text"
                        name="sections[{{ $field['name'] }}]"
                        id="section-{{ $field['name'] }}"
                        value="{{ $value }}"
                        class="block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                      />
                      <button
                        type="button"
                        class="px-3 py-2 rounded border border-gray-300 text-sm hover:bg-gray-50 whitespace-nowrap js-media-picker"
                        data-media-target="section-{{ $field['name'] }}"
                      >Select</button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Use media path like <code>asset/images/media/your-image.jpg</code>.</p>
                  @else
                    <input
                      type="text"
                      name="sections[{{ $field['name'] }}]"
                      value="{{ $value }}"
                      class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    />
                  @endif
                </div>
              @endforeach
            </div>
          </div>

          <div class="flex items-center justify-between">
            <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to page editors</a>
            <button type="submit" class="inline-flex items-center rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
              Save Page
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="media-modal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-5xl max-h-[85vh] overflow-hidden">
      <div class="px-4 py-3 border-b flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-900">Select Media</h3>
        <button type="button" class="text-gray-500 hover:text-gray-900" onclick="closeMediaModal()">✕</button>
      </div>
      <div class="p-4 border-b">
        <input id="media-search" type="search" class="w-full rounded border-gray-300" placeholder="Search media..."/>
      </div>
      <div class="p-4 border-b bg-gray-50">
        <form id="media-upload-form" method="post" action="{{ route('admin.media.upload') }}" enctype="multipart/form-data" class="flex items-center gap-2">
          @csrf
          <input id="media-upload-input" type="file" name="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="block w-full text-sm text-gray-700" />
          <button type="submit" class="px-3 py-2 rounded bg-indigo-600 text-white text-sm whitespace-nowrap">Upload</button>
        </form>
      </div>
      <div id="media-grid" class="p-4 overflow-auto max-h-[60vh] grid grid-cols-2 md:grid-cols-4 gap-3"></div>
      <div class="px-4 py-3 border-t text-right">
        <button type="button" class="px-4 py-2 rounded border border-gray-300 text-sm" onclick="closeMediaModal()">Close</button>
      </div>
    </div>
  </div>

  <input type="hidden" id="media-list-url" value="{{ route('admin.media.list') }}" />

  <script>
    const mediaListUrl = document.getElementById('media-list-url').value;
    const mediaUploadForm = document.getElementById('media-upload-form');
    let mediaTargetInputId = null;
    let mediaItems = [];
    function closeMediaModal() {
      const modal = document.getElementById('media-modal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
    function renderMediaGrid(filter = '') {
      const grid = document.getElementById('media-grid');
      const q = (filter || '').toLowerCase();
      const list = mediaItems.filter((m) => !q || m.name.toLowerCase().includes(q));
      grid.innerHTML = list.map((m) => `
        <button type="button" class="border rounded p-2 text-left hover:bg-gray-50" data-path="${m.path}">
          <img src="${m.url}" alt="" class="w-full h-24 object-cover rounded" />
          <p class="mt-2 text-xs truncate" title="${m.name}">${m.name}</p>
        </button>
      `).join('');
      grid.querySelectorAll('button[data-path]').forEach((btn) => {
        btn.addEventListener('click', () => {
          if (!mediaTargetInputId) return;
          const input = document.getElementById(mediaTargetInputId);
          if (input) input.value = btn.getAttribute('data-path');
          closeMediaModal();
        });
      });
    }
    async function openMediaModal(targetInputId) {
      mediaTargetInputId = targetInputId;
      const modal = document.getElementById('media-modal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      try {
        const res = await fetch(mediaListUrl, { credentials: 'same-origin' });
        const data = await res.json();
        mediaItems = data.media || [];
        renderMediaGrid(document.getElementById('media-search').value);
      } catch (_) {
        mediaItems = [];
        renderMediaGrid('');
      }
    }
    document.getElementById('media-search').addEventListener('input', (e) => {
      renderMediaGrid(e.target.value);
    });
    document.querySelectorAll('.js-media-picker').forEach((btn) => {
      btn.addEventListener('click', () => {
        openMediaModal(btn.getAttribute('data-media-target'));
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
  </script>
</x-app-layout>

