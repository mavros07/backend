@php
  $supportsExistingGalleryDelete = $supportsExistingGalleryDelete ?? false;
  $isAdminUser = auth()->user()?->hasRole('admin');
@endphp

<div id="image-preview-modal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/80 p-4">
  <button type="button" id="image-preview-close" class="absolute right-4 top-4 rounded-md bg-white/10 px-3 py-2 text-sm font-semibold text-white hover:bg-white/20">Close</button>
  <img id="image-preview-modal-image" src="" alt="" class="max-h-[90vh] max-w-[95vw] rounded-lg object-contain" />
</div>

@if($isAdminUser)
  <div id="vehicle-media-modal" class="fixed inset-0 z-[10000] hidden items-center justify-center bg-black/70 p-4">
    <div class="w-full max-w-5xl rounded-lg bg-white shadow-xl">
      <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3">
        <h3 class="text-sm font-semibold text-gray-900">Select Media</h3>
        <button type="button" id="vehicle-media-close" class="text-gray-500 hover:text-gray-900">✕</button>
      </div>
      <div class="border-b border-gray-200 p-4">
        <div class="flex flex-wrap items-center gap-2">
          <input id="vehicle-media-search" type="search" class="w-full rounded-md border-gray-300 text-sm shadow-sm sm:w-72" placeholder="Search media..." />
          <form id="vehicle-media-upload-form" action="{{ route('admin.media.upload') }}" method="post" enctype="multipart/form-data" class="flex flex-wrap items-center gap-2">
            @csrf
            <input id="vehicle-media-upload-input" type="file" name="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="text-sm text-gray-700" />
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">Upload</button>
          </form>
        </div>
        <p class="mt-2 text-xs text-gray-500">Gallery supports multi-select in this modal (Ctrl/Cmd-click, Shift-click range).</p>
      </div>
      <div id="vehicle-media-grid" class="grid max-h-[60vh] grid-cols-2 gap-3 overflow-auto p-4 sm:grid-cols-3 lg:grid-cols-4"></div>
      <div class="flex items-center justify-end gap-2 border-t border-gray-200 px-4 py-3">
        <button type="button" id="vehicle-media-insert" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700" disabled>Use selection</button>
        <button type="button" id="vehicle-media-cancel" class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>
      </div>
    </div>
  </div>
@endif

<script>
  (function () {
    const supportsExistingGalleryDelete = @json((bool) $supportsExistingGalleryDelete);
    const isAdminUser = @json((bool) $isAdminUser);
    const mainInput = document.getElementById('main_image');
    const galleryInput = document.getElementById('images');
    const mainPreview = document.getElementById('main-image-preview');
    const galleryPreview = document.getElementById('gallery-preview');
    const mainClearBtn = document.getElementById('main-image-clear');
    const galleryClearBtn = document.getElementById('gallery-clear-all');
    const modal = document.getElementById('image-preview-modal');
    const modalImage = document.getElementById('image-preview-modal-image');
    const modalClose = document.getElementById('image-preview-close');
    const mainPathInput = document.getElementById('main_image_path');
    const galleryPathsHolder = document.getElementById('gallery-paths-holder');
    const csrfToken = @json(csrf_token());
    let galleryFiles = [];
    let galleryPathItems = [];

    if (!mainInput || !galleryInput || !mainPreview || !galleryPreview || !mainClearBtn || !galleryClearBtn || !modal || !modalImage || !modalClose || !galleryPathsHolder) {
      return;
    }

    function openModal(url) {
      modalImage.src = url;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function closeModal() {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      modalImage.src = '';
      document.body.style.overflow = '';
    }

    function thumb(url, label, onRemove) {
      const wrap = document.createElement('div');
      wrap.className = 'relative overflow-hidden rounded-md border border-gray-200 bg-white';
      wrap.innerHTML =
        '<img src="' + url + '" alt="' + label + '" class="h-28 w-full cursor-zoom-in object-cover">' +
        '<button type="button" class="absolute right-2 top-2 rounded bg-white/90 px-2 py-1 text-xs font-semibold text-red-700 hover:bg-white">Remove</button>';
      wrap.querySelector('img').addEventListener('click', () => openModal(url));
      wrap.querySelector('button').addEventListener('click', onRemove);
      return wrap;
    }

    function toPublicUrl(path) {
      const value = String(path || '').trim();
      if (!value) return '';
      if (/^https?:\/\//i.test(value)) return value;
      return '/' + value.replace(/^\/+/, '');
    }

    function syncGalleryInput() {
      const transfer = new DataTransfer();
      galleryFiles.forEach((file) => transfer.items.add(file));
      galleryInput.files = transfer.files;
    }

    function renderGalleryPathInputs() {
      galleryPathsHolder.innerHTML = '';
      galleryPathItems.forEach((path, index) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'gallery_image_paths[' + index + ']';
        input.value = path;
        galleryPathsHolder.appendChild(input);
      });
    }

    function renderMain() {
      const file = mainInput.files && mainInput.files[0];
      if (!file) {
        const path = (mainPathInput?.value || '').trim();
        if (!path) {
          mainPreview.classList.add('hidden');
          mainPreview.innerHTML = '';
          mainClearBtn.disabled = true;
          return;
        }
        mainPreview.classList.remove('hidden');
        mainPreview.innerHTML = '';
        mainPreview.appendChild(thumb(toPublicUrl(path), 'Main image', () => {
          if (mainPathInput) {
            mainPathInput.value = '';
          }
          renderMain();
        }));
        mainClearBtn.disabled = false;
        return;
      }
      const url = URL.createObjectURL(file);
      if (mainPathInput) {
        mainPathInput.value = '';
      }
      mainPreview.classList.remove('hidden');
      mainPreview.innerHTML = '';
      mainPreview.appendChild(thumb(url, 'Main image', () => {
        mainInput.value = '';
        renderMain();
      }));
      mainClearBtn.disabled = false;
    }

    function renderGallery() {
      const pathUrls = galleryPathItems.map((path) => toPublicUrl(path));
      if (galleryFiles.length === 0 && pathUrls.length === 0) {
        galleryPreview.classList.add('hidden');
        galleryPreview.innerHTML = '';
        galleryClearBtn.disabled = true;
        return;
      }

      galleryPreview.classList.remove('hidden');
      galleryPreview.innerHTML = '';
      pathUrls.forEach((url, index) => {
        galleryPreview.appendChild(thumb(url, 'Gallery image', () => {
          galleryPathItems.splice(index, 1);
          renderGalleryPathInputs();
          renderGallery();
        }));
      });
      galleryFiles.forEach((file, index) => {
        const url = URL.createObjectURL(file);
        galleryPreview.appendChild(thumb(url, 'Gallery image', () => {
          galleryFiles.splice(index, 1);
          syncGalleryInput();
          renderGallery();
        }));
      });
      galleryClearBtn.disabled = false;
    }

    async function removeExistingImage(button) {
      const url = button.getAttribute('data-delete-url');
      const card = button.closest('[data-image-card]');
      if (!url || !card) {
        return;
      }

      button.disabled = true;
      try {
        // Use POST for maximum compatibility with hosting/WAF rules that block DELETE.
        const params = new URLSearchParams();
        params.set('_token', csrfToken);

        const response = await fetch(url, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
          },
          body: params,
          credentials: 'same-origin',
        });

        if (!response.ok) {
          const msg = 'Could not remove image (HTTP ' + String(response.status) + '). Refresh and try again.';
          throw new Error(msg);
        }

        card.remove();
        relabelExistingGallery();
      } catch (error) {
        button.disabled = false;
        alert(error && error.message ? error.message : 'Could not remove image. Please refresh and try again.');
      }
    }

    function relabelExistingGallery() {
      const cards = Array.from(document.querySelectorAll('[data-image-card]'));
      cards.forEach((card, index) => {
        const role = card.querySelector('[data-image-role]');
        if (!role) {
          return;
        }
        const isFirst = index === 0;
        role.textContent = isFirst ? 'Featured image' : 'Gallery image';
        role.classList.toggle('text-indigo-600', isFirst);
        role.classList.toggle('text-gray-500', !isFirst);
      });
    }

    mainInput.addEventListener('change', renderMain);
    mainClearBtn.addEventListener('click', () => {
      if (mainClearBtn.disabled) {
        return;
      }
      mainInput.value = '';
      if (mainPathInput) {
        mainPathInput.value = '';
      }
      renderMain();
    });

    galleryInput.addEventListener('change', () => {
      galleryFiles = Array.from(galleryInput.files || []);
      galleryPathItems = [];
      renderGalleryPathInputs();
      renderGallery();
    });

    galleryClearBtn.addEventListener('click', () => {
      if (galleryClearBtn.disabled) {
        return;
      }
      galleryFiles = [];
      galleryPathItems = [];
      syncGalleryInput();
      renderGalleryPathInputs();
      renderGallery();
    });

    document.querySelectorAll('[data-preview-image]').forEach((img) => {
      img.addEventListener('click', () => openModal(img.getAttribute('src')));
    });

    if (supportsExistingGalleryDelete) {
      document.querySelectorAll('[data-remove-image]').forEach((button) => {
        button.addEventListener('click', () => removeExistingImage(button));
      });
    }

    modalClose.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
      if (event.target === modal) {
        closeModal();
      }
    });

    renderMain();
    renderGallery();

    if (!isAdminUser) {
      return;
    }

    const mediaModal = document.getElementById('vehicle-media-modal');
    const mediaGrid = document.getElementById('vehicle-media-grid');
    const mediaSearch = document.getElementById('vehicle-media-search');
    const mediaInsert = document.getElementById('vehicle-media-insert');
    const mediaClose = document.getElementById('vehicle-media-close');
    const mediaCancel = document.getElementById('vehicle-media-cancel');
    const mediaUploadForm = document.getElementById('vehicle-media-upload-form');
    const mediaListUrl = @json(route('admin.media.list'));
    let mediaItems = [];
    let mediaTarget = null;
    let mediaSelected = [];
    let shiftAnchor = null;

    if (!mediaModal || !mediaGrid || !mediaSearch || !mediaInsert || !mediaClose || !mediaCancel || !mediaUploadForm) {
      return;
    }

    function openMediaPicker(target) {
      mediaTarget = target;
      mediaSelected = [];
      shiftAnchor = null;
      mediaInsert.disabled = true;
      mediaModal.classList.remove('hidden');
      mediaModal.classList.add('flex');
      document.body.style.overflow = 'hidden';
      fetchMediaItems();
    }

    function closeMediaPicker() {
      mediaModal.classList.add('hidden');
      mediaModal.classList.remove('flex');
      mediaTarget = null;
      document.body.style.overflow = '';
    }

    async function fetchMediaItems() {
      const response = await fetch(mediaListUrl, { credentials: 'same-origin' });
      const data = await response.json();
      mediaItems = Array.isArray(data.media) ? data.media : [];
      renderMediaGrid();
    }

    function renderMediaGrid() {
      const escapeHtml = (value) => String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
      const q = (mediaSearch.value || '').toLowerCase();
      const items = mediaItems.filter((item) => !q || (item.name || '').toLowerCase().includes(q));
      mediaGrid.innerHTML = items.map((item, index) => {
        const selected = mediaSelected.includes(item.path);
        return '<button type="button" data-path="' + encodeURIComponent(item.path || '') + '" data-index="' + index + '" class="rounded-lg border p-2 text-left ' +
          (selected ? 'border-indigo-500 ring-2 ring-indigo-300 bg-indigo-50' : 'border-gray-200 hover:border-indigo-300') +
          '"><img src="' + escapeHtml(item.url || '') + '" class="h-24 w-full rounded object-cover" alt="">' +
          '<p class="mt-2 truncate text-xs text-gray-700">' + escapeHtml(item.name || '') + '</p></button>';
      }).join('');

      mediaGrid.querySelectorAll('button[data-path]').forEach((button) => {
        button.addEventListener('click', (event) => {
          const path = decodeURIComponent(button.getAttribute('data-path') || '');
          const idx = Number(button.getAttribute('data-index'));
          if (!path) return;

          if (mediaTarget === 'gallery' && event.shiftKey && shiftAnchor !== null) {
            const [start, end] = [Math.min(shiftAnchor, idx), Math.max(shiftAnchor, idx)];
            mediaSelected = items.slice(start, end + 1).map((item) => item.path);
          } else if (mediaTarget === 'gallery' && (event.ctrlKey || event.metaKey)) {
            if (mediaSelected.includes(path)) {
              mediaSelected = mediaSelected.filter((value) => value !== path);
            } else {
              mediaSelected.push(path);
            }
            shiftAnchor = idx;
          } else {
            mediaSelected = [path];
            shiftAnchor = idx;
          }

          mediaInsert.disabled = mediaSelected.length === 0;
          renderMediaGrid();
        });
      });
    }

    mediaInsert.addEventListener('click', () => {
      if (mediaSelected.length === 0) return;

      if (mediaTarget === 'main') {
        mainInput.value = '';
        if (mainPathInput) {
          mainPathInput.value = mediaSelected[0];
        }
        renderMain();
      } else if (mediaTarget === 'gallery') {
        galleryFiles = [];
        syncGalleryInput();
        galleryPathItems = mediaSelected.slice();
        renderGalleryPathInputs();
        renderGallery();
      }

      closeMediaPicker();
    });

    mediaSearch.addEventListener('input', renderMediaGrid);
    mediaClose.addEventListener('click', closeMediaPicker);
    mediaCancel.addEventListener('click', closeMediaPicker);
    mediaModal.addEventListener('click', (event) => {
      if (event.target === mediaModal) closeMediaPicker();
    });

    document.getElementById('main-image-library')?.addEventListener('click', () => openMediaPicker('main'));
    document.getElementById('gallery-library')?.addEventListener('click', () => openMediaPicker('gallery'));

    mediaUploadForm.addEventListener('submit', async (event) => {
      event.preventDefault();
      const formData = new FormData(mediaUploadForm);
      const token = mediaUploadForm.querySelector('input[name="_token"]')?.value || '';
      await fetch(mediaUploadForm.action, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
        body: formData,
      });
      mediaUploadForm.reset();
      await fetchMediaItems();
    });
  })();
</script>
