<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            MediaSeeder::class,
        ]);

        // Hubungkan contoh koleksi awal pada tabel pivot media_user
        $users = User::orderBy('id')->get();
        $mediaItems = Media::orderBy('id')->pluck('id')->all();

        if ($users->count() >= 3 && count($mediaItems) >= 6) {
            $users[0]->media()->syncWithoutDetaching([$mediaItems[0], $mediaItems[4]]);
            $users[1]->media()->syncWithoutDetaching([$mediaItems[0], $mediaItems[2], $mediaItems[3]]);
            $users[2]->media()->syncWithoutDetaching([$mediaItems[1], $mediaItems[5]]);
        }
    }
}
