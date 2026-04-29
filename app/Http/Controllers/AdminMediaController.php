<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminMediaController extends Controller
{
    protected function mediaDir(): string
    {
        return public_path('asset/images/media');
    }

    protected function syncExistingMediaFiles(): void
    {
        $dir = $this->mediaDir();
        if (! is_dir($dir)) {
            return;
        }

        foreach (File::files($dir) as $file) {
            $name = $file->getFilename();
            Media::query()->firstOrCreate(
                ['file_path' => 'asset/images/media/'.$name],
                [
                    'filename' => $name,
                    'original_name' => $name,
                    'file_type' => $file->getExtension(),
                    'file_size' => (int) $file->getSize(),
                ]
            );
        }
    }

    /**
     * @return array<int, array{id: int, name: string, path: string, url: string, size: int, modified_at: int}>
     */
    protected function mediaItems(): array
    {
        $this->syncExistingMediaFiles();

        return Media::query()
            ->latest()
            ->get()
            ->map(static function (Media $item): array {
                return [
                    'id' => (int) $item->id,
                    'name' => $item->filename,
                    'path' => $item->file_path,
                    'url' => asset($item->file_path),
                    'size' => (int) $item->file_size,
                    'modified_at' => $item->updated_at?->timestamp ?? $item->created_at?->timestamp ?? time(),
                ];
            })
            ->all();
    }

    public function index(Request $request): View
    {
        $query = trim((string) $request->query('q', ''));
        $items = $this->mediaItems();
        if ($query !== '') {
            $items = array_values(array_filter($items, static function (array $item) use ($query): bool {
                return Str::contains(Str::lower($item['name']), Str::lower($query));
            }));
        }

        return view('admin.media.index', [
            'items' => $items,
            'query' => $query,
        ]);
    }

    public function list(Request $request): JsonResponse
    {
        $query = trim((string) $request->query('search', ''));
        $items = $this->mediaItems();
        if ($query !== '') {
            $items = array_values(array_filter($items, static function (array $item) use ($query): bool {
                return Str::contains(Str::lower($item['name']), Str::lower($query));
            }));
        }

        return response()->json([
            'success' => true,
            'media' => $items,
        ]);
    }

    public function upload(Request $request): RedirectResponse|JsonResponse
    {
        $single = $request->file('file');
        $many = $request->file('files', []);
        if ($single !== null && $many === []) {
            $many = [$single];
        }
        if (! is_array($many) || count($many) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one image.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        foreach ($many as $f) {
            if (! $f || ! str_starts_with((string) $f->getMimeType(), 'image/')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only images are allowed.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if ((int) $f->getSize() > 5 * 1024 * 1024) {
                return response()->json([
                    'success' => false,
                    'message' => 'Each image must be 5MB or smaller.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $dir = $this->mediaDir();
        if (! is_dir($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $files = $many;
        $uploadedCount = 0;

        foreach ($files as $file) {
            $name = Str::slug(pathinfo((string) $file->getClientOriginalName(), PATHINFO_FILENAME));
            $ext = strtolower((string) $file->getClientOriginalExtension());
            $size = (int) $file->getSize();
            $filename = ($name !== '' ? $name : 'media').'-'.Str::random(6).'-'.time().'.'.$ext;
            
            $file->move($dir, $filename);
            
            Media::query()->create([
                'filename' => $filename,
                'original_name' => (string) $file->getClientOriginalName(),
                'file_path' => 'asset/images/media/'.$filename,
                'file_type' => $ext,
                'file_size' => $size,
                'uploaded_by' => $request->user()?->id,
            ]);
            $uploadedCount++;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $uploadedCount . ' media file(s) uploaded successfully.',
            ], Response::HTTP_CREATED);
        }

        return redirect()
            ->route('admin.media.index')
            ->with('status', $uploadedCount . ' media file(s) uploaded successfully.');
    }

    public function destroy(Request $request, Media $media): RedirectResponse|JsonResponse
    {
        $fullPath = public_path($media->file_path);
        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
        $media->delete();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media deleted successfully.',
            ]);
        }

        return redirect()->route('admin.media.index')->with('status', 'Media deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

        $items = Media::query()->whereIn('id', $data['ids'])->get();
        foreach ($items as $item) {
            $fullPath = public_path($item->file_path);
            if (is_file($fullPath)) {
                @unlink($fullPath);
            }
            $item->delete();
        }

        return redirect()->route('admin.media.index')->with('status', 'Selected media deleted successfully.');
    }
}

