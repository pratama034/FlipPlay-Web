<?php

declare(strict_types=1);

namespace FlipPlay\Engine\Model;

/**
 * Class Manga mewarisi (Inheritance) dari Abstract Class Media.
 * Merepresentasikan katalog komik Jepang (Manga) maupun novel ringan (Light Novel).
 */
class Manga extends Media
{
    /**
     * @param int $id ID unik MAL
     * @param string $title Judul manga / light novel
     * @param ?float $score Skor rating
     * @param ?int $year Tahun publikasi
     * @param ?string $synopsis Sinopsis cerita
     * @param ?string $posterUrl URL sampul gambar
     * @param array<int, string> $genres Daftar genre
     * @param array<int, string> $themes Daftar tema / aura
     * @param ?int $chapters Jumlah total chapter
     * @param string $format Jenis publikasi ("Manga" atau "Light Novel")
     */
    public function __construct(
        int $id,
        string $title,
        ?float $score = null,
        ?int $year = null,
        ?string $synopsis = null,
        ?string $posterUrl = null,
        array $genres = [],
        array $themes = [],
        private ?int $chapters = null,
        private string $format = 'Manga'
    ) {
        parent::__construct(
            $id,
            $title,
            $score,
            $year,
            $synopsis,
            $posterUrl,
            $genres,
            $themes
        );
    }

    public function getChapters(): ?int
    {
        return $this->chapters;
    }

    public function setChapters(?int $chapters): void
    {
        $this->chapters = $chapters;
    }

    public function getFormat(): string
    {
        return $this->format;
    }

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    /**
     * Override method abstrak dari class induk Media.
     */
    public function getMediaType(): string
    {
        return $this->format;
    }

    /**
     * Override method abstrak untuk menampilkan ringkasan informasi kartu Manga / Light Novel.
     */
    public function getDetailsSummary(): string
    {
        $yearLabel = $this->year !== null ? (string) $this->year : 'Tahun belum tersedia';
        $chapterLabel = $this->chapters !== null ? "{$this->chapters} chapter" : 'Chapter belum tersedia';

        return "{$this->getMediaType()} · {$yearLabel} · {$chapterLabel}";
    }
}

