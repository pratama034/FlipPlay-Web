<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserCollectionController extends Controller
{
    /**
     * Menampilkan profil user beserta seluruh daftar koleksi medianya.
     */
    public function index(User $user): UserResource
    {
        $user->load('media');

        return new UserResource($user);
    }

    /**
     * Menambahkan media ke dalam koleksi pribadi user.
     */
    public function store(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'media_id' => ['required', 'integer', 'exists:media,id'],
        ], [
            'media_id.required' => 'ID media wajib diisi.',
            'media_id.integer' => 'ID media harus berupa angka bulat.',
            'media_id.exists' => 'Media tidak ditemukan di dalam katalog.',
        ]);

        if ($user->media()->where('media_id', $validated['media_id'])->exists()) {
            return response()->json([
                'message' => 'Media sudah ada di koleksi',
            ], 409);
        }

        $user->media()->attach($validated['media_id']);
        $user->load('media');

        return response()->json([
            'message' => 'Media berhasil ditambahkan ke koleksi',
            'data' => new UserResource($user),
        ], 200);
    }

    /**
     * Menghapus media dari koleksi pribadi user.
     */
    public function destroy(User $user, Media $media): JsonResponse
    {
        if (!$user->media()->where('media_id', $media->id)->exists()) {
            return response()->json([
                'message' => 'Media tidak ditemukan di koleksi user',
            ], 404);
        }

        $user->media()->detach($media->id);

        return response()->json([
            'message' => 'Media berhasil dihapus dari koleksi',
        ], 200);
    }
}
