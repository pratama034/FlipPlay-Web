<?php

declare(strict_types=1);

namespace FlipPlay\Engine\Collection;

use FlipPlay\Engine\Model\Media;

/**
 * Class UserLibrary bertanggung jawab mengelola koleksi objek Media milik pengguna.
 * Mendukung operasi tambah, hapus, pencarian judul, dan filter berdasarkan tipe maupun tema/aura.
 */
class UserLibrary
{
    /**
     * Penyimpanan internal objek Media yang diindeks berdasarkan ID media.
     *
     * @var array<int, Media>
     */
    private array $items = [];

    /**
     * Constructor dengan Constructor Property Promotion PHP 8.
     *
     * @param ?int $maxCapacity Batas maksimal koleksi (null = tanpa batas / unlimited)
     */
    public function __construct(
        private ?int $maxCapacity = null
    ) {
    }

    public function getMaxCapacity(): ?int
    {
        return $this->maxCapacity;
    }

    public function setMaxCapacity(?int $maxCapacity): void
    {
        $this->maxCapacity = $maxCapacity;
    }

    /**
     * Menambahkan objek Media (Anime / Manga) ke dalam library pengguna.
     * Mengembalikan false apabila kapasitas sudah penuh.
     */
    public function addMedia(Media $media): bool
    {
        $mediaId = $media->getId();

        // Jika item belum ada dan kuota kapasitas penuh, tolak penambahan
        if (!isset($this->items[$mediaId]) && $this->maxCapacity !== null && count($this->items) >= $this->maxCapacity) {
            return false;
        }

        $this->items[$mediaId] = $media;
        return true;
    }

    /**
     * Menghapus objek Media dari library berdasarkan ID.
     */
    public function removeMedia(int $mediaId): bool
    {
        if (!isset($this->items[$mediaId])) {
            return false;
        }

        unset($this->items[$mediaId]);
        return true;
    }

    /**
     * Mengambil satu objek Media berdasarkan ID (mengembalikan null jika tidak ditemukan).
     */
    public function getMediaById(int $mediaId): ?Media
    {
        return $this->items[$mediaId] ?? null;
    }

    /**
     * Mengembalikan seluruh daftar objek Media yang tersimpan.
     *
     * @return array<int, Media>
     */
    public function getAll(): array
    {
        return array_values($this->items);
    }

    /**
     * Menghitung jumlah total item di dalam library.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Mencari daftar media berdasarkan kata kunci judul (case-insensitive).
     * Merepresentasikan fitur #anime-search di The Vibe Grid.
     *
     * @return array<int, Media>
     */
    public function searchByTitle(string $keyword): array
    {
        $normalizedKeyword = trim($keyword);
        if ($normalizedKeyword === '') {
            return $this->getAll();
        }

        $results = array_filter(
            $this->items,
            static fn(Media $media): bool => stripos($media->getTitle(), $normalizedKeyword) !== false
        );

        return array_values($results);
    }

    /**
     * Menyaring koleksi berdasarkan jenis media ("Anime", "Manga", "Light Novel").
     *
     * @return array<int, Media>
     */
    public function filterByType(string $mediaType): array
    {
        $normalizedType = strtolower(trim($mediaType));

        $results = array_filter(
            $this->items,
            static fn(Media $media): bool => strtolower($media->getMediaType()) === $normalizedType
        );

        return array_values($results);
    }

    /**
     * Menyaring koleksi berdasarkan tema atau aura emosional
     * (misal: "action", "comedy", "drama", "fantasy", "mystery", "slice-of-life").
     *
     * @return array<int, Media>
     */
    public function filterByTheme(string $theme): array
    {
        $results = array_filter(
            $this->items,
            static fn(Media $media): bool => $media->hasTheme($theme)
        );

        return array_values($results);
    }
}

