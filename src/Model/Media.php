<?php

declare(strict_types=1);

namespace FlipPlay\Engine\Model;

/**
 * Class Abstrak Media sebagai blueprint induk untuk seluruh entitas katalog FlipPlay.
 */
abstract class Media
{
    /**
     * Constructor menggunakan fitur Constructor Property Promotion PHP 8.
     *
     * @param int $id ID unik dari MyAnimeList (mal_id)
     * @param string $title Judul utama karya
     * @param ?float $score Skor rating (nullable jika belum ada skor)
     * @param ?int $year Tahun rilis (nullable jika belum diketahui)
     * @param ?string $synopsis Ringkasan cerita / sinopsis lengkap
     * @param ?string $posterUrl URL gambar poster dari Jikan API
     * @param array<int, string> $genres Daftar genre
     * @param array<int, string> $themes Daftar tema / aura emosional
     */
    public function __construct(
        protected int $id,
        protected string $title,
        protected ?float $score = null,
        protected ?int $year = null,
        protected ?string $synopsis = null,
        protected ?string $posterUrl = null,
        protected array $genres = [],
        protected array $themes = []
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): void
    {
        $this->score = $score;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): void
    {
        $this->synopsis = $synopsis;
    }

    public function getPosterUrl(): ?string
    {
        return $this->posterUrl;
    }

    public function setPosterUrl(?string $posterUrl): void
    {
        $this->posterUrl = $posterUrl;
    }

    /**
     * @return array<int, string>
     */
    public function getGenres(): array
    {
        return $this->genres;
    }

    /**
     * @return array<int, string>
     */
    public function getThemes(): array
    {
        return $this->themes;
    }

    /**
     * Mengecek apakah karya media ini memiliki tema/aura tertentu (case-insensitive).
     */
    public function hasTheme(string $theme): bool
    {
        $normalizedTarget = strtolower(trim($theme));
        foreach ($this->themes as $itemTheme) {
            if (strtolower($itemTheme) === $normalizedTarget) {
                return true;
            }
        }
        return false;
    }

    /**
     * Method abstrak yang wajib diimplementasikan oleh class turunan
     * untuk mengembalikan jenis media (misal: "Anime", "Manga", "Light Novel").
     */
    abstract public function getMediaType(): string;

    /**
     * Method abstrak untuk menghasilkan ringkasan metadata kartu katalog.
     */
    abstract public function getDetailsSummary(): string;
}

