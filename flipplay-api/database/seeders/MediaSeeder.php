<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catalog = [
            [
                'title' => 'Black Clover',
                'type' => 'anime',
                'genre' => 'Action, Fantasy',
                'release_year' => 2017,
                'total_units' => 170,
                'status' => 'completed',
                'description' => 'Asta lahir tanpa kekuatan sihir di dunia tempat sihir adalah segalanya, namun bertekad menjadi Kaisar Sihir.',
            ],
            [
                'title' => 'Attack on Titan',
                'type' => 'anime',
                'genre' => 'Action, Drama',
                'release_year' => 2013,
                'total_units' => 89,
                'status' => 'completed',
                'description' => 'Umat manusia bertarung mempertahankan hidup di balik tembok raksasa dari ancaman para Titan pemangsa.',
            ],
            [
                'title' => 'SPY x FAMILY',
                'type' => 'anime',
                'genre' => 'Action, Comedy',
                'release_year' => 2022,
                'total_units' => 37,
                'status' => 'ongoing',
                'description' => 'Seorang agen mata-mata bernama Twilight membangun keluarga palsu demi menjalankan misi perdamaian rahasia.',
            ],
            [
                'title' => 'Soundtrack #1',
                'type' => 'manga',
                'genre' => 'Romance, Slice of Life',
                'release_year' => 2022,
                'total_units' => 16,
                'status' => 'completed',
                'description' => 'Kisah penulis lirik dan fotografer yang bersahabat selama 20 tahun dan mulai menyadari perasaan satu sama lain.',
            ],
            [
                'title' => "Frieren: Beyond Journey's End",
                'type' => 'manga',
                'genre' => 'Adventure, Fantasy',
                'release_year' => 2020,
                'total_units' => 135,
                'status' => 'ongoing',
                'description' => 'Penyihir elf Frieren menempuh perjalanan baru setelah mengalahkan Raja Iblis demi memahami arti waktu dan manusia.',
            ],
            [
                'title' => 'Blue Lock',
                'type' => 'manga',
                'genre' => 'Sports, Action',
                'release_year' => 2018,
                'total_units' => 280,
                'status' => 'ongoing',
                'description' => 'Tiga ratus penyerang muda terbaik Jepang dikumpulkan dalam proyek ekstrem demi mencetak striker nomor satu dunia.',
            ],
        ];

        foreach ($catalog as $item) {
            Media::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
