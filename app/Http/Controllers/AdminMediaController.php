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
     * @return array<int, array{name: string, path: string, url: string, size: int, modified_at: int}>
     */
    protected function mediaItems(): array
    {
        $this->syncExistingMediaFiles();

        return Media::query()
            ->latest()
            ->get()
            ->map(static function (Media $item): array {
                return [
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
        $data = $request->validate([
            'file' => ['required', 'image', 'max:5120'],
        ]);

        $dir = $this->mediaDir();
        if (! is_dir($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $file = $data['file'];
        $name = Str::slug(pathinfo((string) $file->getClientOriginalName(), PATHINFO_FILENAME));
        $ext = strtolower((string) $file->getClientOriginalExtension());
        $size = (int) $file->getSize();
        $filename = ($name !== '' ? $name : 'media').'-'.time().'.'.$ext;
        $file->move($dir, $filename);
        Media::query()->create([
            'filename' => $filename,
            'original_name' => (string) $file->getClientOriginalName(),
            'file_path' => 'asset/images/media/'.$filename,
            'file_type' => $ext,
            'file_size' => $size,
            'uploaded_by' => $request->user()?->id,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Media uploaded successfully.',
            ], Response::HTTP_CREATED);
        }

        return redirect()
            ->route('admin.media.index')
            ->with('status', 'Media uploaded successfully.');
    }
}

