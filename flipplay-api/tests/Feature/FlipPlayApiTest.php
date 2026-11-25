<?php

namespace Tests\Feature;

use App\Models\Media;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlipPlayApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_index_returns_paginated_media_and_supports_search(): void
    {
        $response = $this->getJson('/api/media');
        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'type', 'genre', 'release_year', 'total_units', 'status', 'description'],
                ],
                'links',
                'meta',
            ]);

        $searchResponse = $this->getJson('/api/media?search=Black');
        $searchResponse->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Black Clover');
    }

    public function test_show_returns_media_with_users_relationship(): void
    {
        $media = Media::where('title', 'Black Clover')->firstOrFail();

        $response = $this->getJson("/api/media/{$media->id}");
        $response->assertOk()
            ->assertJsonPath('data.title', 'Black Clover')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'users' => [
                        '*' => ['id', 'name', 'email'],
                    ],
                ],
            ]);
    }

    public function test_store_creates_media_and_returns_201(): void
    {
        $payload = [
            'title' => 'Demon Slayer: Kimetsu no Yaiba',
            'type' => 'anime',
            'genre' => 'Action, Supernatural',
            'release_year' => 2019,
            'total_units' => 26,
            'description' => 'Kisah Tanjiro Kamado membasmi iblis.',
        ];

        $response = $this->postJson('/api/media', $payload);
        $response->assertCreated()
            ->assertJsonPath('data.title', 'Demon Slayer: Kimetsu no Yaiba')
            ->assertJsonPath('data.status', 'completed');

        $this->assertDatabaseHas('media', ['title' => 'Demon Slayer: Kimetsu no Yaiba']);
    }

    public function test_store_validation_fails_with_422_and_indonesian_messages(): void
    {
        $response = $this->postJson('/api/media', [
            'title' => 'Black Clover',
            'type' => 'film',
            'genre' => '',
            'release_year' => 1800,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'type', 'genre', 'release_year'])
            ->assertJsonPath('errors.title.0', 'Judul media sudah terdaftar di dalam katalog.')
            ->assertJsonPath('errors.type.0', 'Tipe media hanya boleh bernilai anime atau manga.');
    }

    public function test_patch_updates_partially_and_ignores_own_unique_title(): void
    {
        $media = Media::where('title', 'SPY x FAMILY')->firstOrFail();

        $response = $this->patchJson("/api/media/{$media->id}", [
            'title' => 'SPY x FAMILY',
            'total_units' => 38,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.total_units', 38)
            ->assertJsonPath('data.title', 'SPY x FAMILY');
    }

    public function test_destroy_deletes_media_and_returns_message(): void
    {
        $media = Media::where('title', 'Blue Lock')->firstOrFail();

        $response = $this->deleteJson("/api/media/{$media->id}");
        $response->assertOk()
            ->assertJsonPath('message', 'Media berhasil dihapus');

        $this->assertDatabaseMissing('media', ['id' => $media->id]);
    }

    public function test_user_collection_index_store_duplicate_409_and_destroy(): void
    {
        $user = User::orderBy('id')->firstOrFail();
        $existingMedia = $user->media()->firstOrFail();
        $unattachedMedia = Media::whereNotIn('id', $user->media()->pluck('media.id'))->firstOrFail();

        // GET collection
        $this->getJson("/api/users/{$user->id}/collection")
            ->assertOk()
            ->assertJsonStructure([
                'data' => ['id', 'name', 'email', 'collection'],
            ]);

        // POST duplicate -> 409 Conflict
        $this->postJson("/api/users/{$user->id}/collection", ['media_id' => $existingMedia->id])
            ->assertStatus(409)
            ->assertJsonPath('message', 'Media sudah ada di koleksi');

        // POST new media -> 200 OK
        $this->postJson("/api/users/{$user->id}/collection", ['media_id' => $unattachedMedia->id])
            ->assertOk();

        // DELETE attached media -> 200 OK
        $this->deleteJson("/api/users/{$user->id}/collection/{$unattachedMedia->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Media berhasil dihapus dari koleksi');

        // DELETE non-attached media -> 404 Not Found
        $this->deleteJson("/api/users/{$user->id}/collection/{$unattachedMedia->id}")
            ->assertStatus(404);
    }

    public function test_returns_404_for_missing_media_or_user(): void
    {
        $this->getJson('/api/media/99999')->assertStatus(404);
        $this->getJson('/api/users/99999/collection')->assertStatus(404);
    }
}
