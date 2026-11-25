<?php

declare(strict_types=1);

// Memuat seluruh file class sesuai hierarki dependensi
require_once __DIR__ . '/src/Model/Media.php';
require_once __DIR__ . '/src/Model/Anime.php';
require_once __DIR__ . '/src/Model/Manga.php';
require_once __DIR__ . '/src/Collection/UserLibrary.php';
require_once __DIR__ . '/src/Account/User.php';

use FlipPlay\Engine\Account\User;
use FlipPlay\Engine\Model\Anime;
use FlipPlay\Engine\Model\Manga;
use FlipPlay\Engine\Model\Media;

/**
 * Fungsi helper untuk mencetak daftar koleksi Media ke CLI secara rapi.
 *
 * @param array<int, Media> $mediaList
 */
function printMediaCollection(array $mediaList): void
{
    if (count($mediaList) === 0) {
        echo "   (Tidak ada data media yang cocok)\n";
        return;
    }

    foreach ($mediaList as $media) {
        $scoreText = $media->getScore() !== null ? number_format($media->getScore(), 2) : 'N/A';
        printf(
            "   - [ID: %d] %s (★ %s) | %s\n",
            $media->getId(),
            $media->getTitle(),
            $scoreText,
            $media->getDetailsSummary()
        );
    }
}

echo "=================================================================\n";
echo "         FLIPPLAY BACKEND ENGINE — SIMULASI PHP 8 OOP CLI        \n";
echo "=================================================================\n\n";

// -------------------------------------------------------------------------
// 1. Inisialisasi Akun Pengguna (Relasi Composition dengan UserLibrary)
// -------------------------------------------------------------------------
echo "[1] Inisialisasi Akun Pengguna FlipPlay...\n";
$user = new User(
    id: 1001,
    name: 'Adit Pratama',
    email: 'adit@flipplay.id',
    subscriptionPlan: 'Pro'
);
echo "    Status Awal -> " . $user->getProfileSummary() . "\n\n";

// -------------------------------------------------------------------------
// 2. Instansiasi Objek Anime & Manga (Data berbasis Jikan API v4)
// -------------------------------------------------------------------------
echo "[2] Instansiasi Objek Katalog (Anime & Manga)...\n";

$aot = new Anime(
    id: 16498,
    title: 'Attack on Titan',
    score: 8.54,
    year: 2013,
    synopsis: 'Manusia berlindung di balik tembok raksasa dari ancaman Titan. Eren Yeager bersumpah membasmi seluruh Titan setelah kotanya dihancurkan.',
    posterUrl: 'https://cdn.myanimelist.net/images/anime/10/47347l.jpg',
    genres: ['Action', 'Award Winning', 'Drama', 'Suspense'],
    themes: ['action', 'drama', 'mystery'],
    episodes: 25,
    youtubeTrailerId: 'MGRm4IzK1SQ'
);

$spyFamily = new Anime(
    id: 50265,
    title: 'SPY x FAMILY',
    score: 8.50,
    year: 2022,
    synopsis: 'Agen rahasia Twilight harus membangun keluarga palsu demi menjalankan misi perdamaian, tanpa menyadari putrinya seorang esper.',
    posterUrl: 'https://cdn.myanimelist.net/images/anime/1441/122795l.jpg',
    genres: ['Action', 'Comedy'],
    themes: ['action', 'comedy', 'slice-of-life'],
    episodes: 25,
    youtubeTrailerId: 'ofXigq9aIpo'
);

$yourLieInApril = new Anime(
    id: 23273,
    title: 'Your Lie in April',
    score: 8.64,
    year: 2014,
    synopsis: 'Pianis muda Kousei Arima kembali menemukan warna musik setelah bertemu pemain biola bebas bernama Kaori Miyazono.',
    posterUrl: 'https://cdn.myanimelist.net/images/anime/3/67177l.jpg',
    genres: ['Drama', 'Romance'],
    themes: ['romance', 'drama', 'slice-of-life'],
    episodes: 22,
    youtubeTrailerId: '3aL0gDZtFbE'
);

$frieren = new Manga(
    id: 126287,
    title: "Frieren: Beyond Journey's End",
    score: 9.35,
    year: 2020,
    synopsis: 'Setelah kelompok pahlawan mengalahkan Raja Iblis, penyihir elf Frieren memulai perjalanan baru untuk memahami arti waktu dan manusia.',
    posterUrl: 'https://cdn.myanimelist.net/images/manga/3/234715l.jpg',
    genres: ['Adventure', 'Drama', 'Fantasy'],
    themes: ['fantasy', 'drama', 'adventure'],
    chapters: 135,
    format: 'Manga'
);

$apothecaryNovels = new Manga(
    id: 86769,
    title: 'The Apothecary Diaries',
    score: 8.92,
    year: 2014,
    synopsis: 'Maomao, seorang apoteker cerdas, memecahkan berbagai misteri racun dan intrik di dalam istana kekaisaran.',
    posterUrl: 'https://cdn.myanimelist.net/images/manga/3/263638l.jpg',
    genres: ['Drama', 'Mystery'],
    themes: ['mystery', 'drama', 'romance'],
    chapters: 45,
    format: 'Light Novel'
);

echo "    Berhasil membuat 3 objek Anime dan 2 objek Manga/Light Novel.\n\n";

// -------------------------------------------------------------------------
// 3. Menyimpan Media ke dalam UserLibrary
// -------------------------------------------------------------------------
echo "[3] Menambahkan Media ke dalam UserLibrary Pengguna...\n";
$library = $user->getLibrary();
$library->addMedia($aot);
$library->addMedia($spyFamily);
$library->addMedia($yourLieInApril);
$library->addMedia($frieren);
$library->addMedia($apothecaryNovels);

echo "    " . $user->getProfileSummary() . "\n";
echo "    Daftar Seluruh Koleksi Saat Ini:\n";
printMediaCollection($library->getAll());
echo "\n";

// -------------------------------------------------------------------------
// 4. Uji Coba Fitur Search Berdasarkan Judul
// -------------------------------------------------------------------------
$searchQuery = 'family';
echo "[4] Uji Coba Pencarian Judul (Kata Kunci: '{$searchQuery}')...\n";
$searchResults = $library->searchByTitle($searchQuery);
printMediaCollection($searchResults);
echo "\n";

// -------------------------------------------------------------------------
// 5. Uji Coba Fitur Filter Berdasarkan Tema / Aura
// -------------------------------------------------------------------------
$auraTheme = 'action';
echo "[5] Uji Coba Filter Aura: High Energy / '{$auraTheme}'...\n";
$filteredByTheme = $library->filterByTheme($auraTheme);
printMediaCollection($filteredByTheme);
echo "\n";

$mediaType = 'Light Novel';
echo "[6] Uji Coba Filter Tipe Media: '{$mediaType}'...\n";
$filteredByType = $library->filterByType($mediaType);
printMediaCollection($filteredByType);
echo "\n";

// -------------------------------------------------------------------------
// 7. Inspeksi Detail Spesifik Anime (Sinopsis & Trailer Embed URL)
// -------------------------------------------------------------------------
echo "[7] Inspeksi Detail Modal Anime (Polimorfisme & Method Khusus Anime)...\n";
echo "    Judul        : " . $aot->getTitle() . "\n";
echo "    Genre        : " . implode(', ', $aot->getGenres()) . "\n";
echo "    Sinopsis     : " . $aot->getSynopsis() . "\n";
echo "    Trailer URL  : " . ($aot->getTrailerEmbedUrl() ?? 'Tidak tersedia') . "\n\n";

// -------------------------------------------------------------------------
// 8. Uji Coba Hapus Media & Upgrade Paket Langganan
// -------------------------------------------------------------------------
echo "[8] Menghapus 1 Item (ID: 23273 - Your Lie in April) & Upgrade ke Paket 'Premium'...\n";
$library->removeMedia(23273);
$user->upgradePlan('Premium');
echo "    Status Akhir -> " . $user->getProfileSummary() . "\n\n";

echo "=================================================================\n";
echo "                SIMULASI SELESAI TANPA ERROR                     \n";
echo "=================================================================\n";
