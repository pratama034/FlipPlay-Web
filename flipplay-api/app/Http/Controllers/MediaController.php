<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MediaController extends Controller
{
    /**
     * Menampilkan daftar media dengan filter pencarian (?search=) dan pagination.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $media = Media::query()
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->orderBy('id')
            ->paginate(10);

        return MediaResource::collection($media);
    }

    /**
     * Menyimpan data media baru ke katalog.
     */
    public function store(StoreMediaRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (empty($validated['status'])) {
            $validated['status'] = 'completed';
        }

        $media = Media::create($validated)->refresh();

        return (new MediaResource($media))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Menampilkan detail satu media beserta daftar user yang menyimpannya.
     */
    public function show(Media $media): MediaResource
    {
        $media->load('users');

        return new MediaResource($media);
    }

    /**
     * Memperbarui data media di katalog (mendukung PUT & PATCH).
     */
    public function update(StoreMediaRequest $request, Media $media): MediaResource
    {
        $media->update($request->validated());

        return new MediaResource($media->fresh());
    }

    /**
     * Menghapus data media dari katalog.
     */
    public function destroy(Media $media): JsonResponse
    {
        $media->delete();

        return response()->json([
            'message' => 'Media berhasil dihapus',
        ], 200);
    }
}
