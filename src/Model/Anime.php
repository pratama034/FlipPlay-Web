<?php

declare(strict_types=1);

namespace FlipPlay\Engine\Model;

/**
 * Class Anime mewarisi (Inheritance) dari Abstract Class Media.
 * Menyimpan atribut dan perilaku spesifik tayangan animasi.
 */
class Anime extends Media
{
    /**
     * @param int $id ID unik MAL
     * @param string $title Judul anime
     * @param ?float $score Skor rating
     * @param ?int $year Tahun tayang
     * @param ?string $synopsis Sinopsis cerita
     * @param ?string $posterUrl URL poster gambar
     * @param array<int, string> $genres Daftar genre
     * @param array<int, string> $themes Daftar tema / aura
     * @param ?int $episodes Jumlah total episode
     * @param ?string $youtubeTrailerId ID video trailer YouTube
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
        private ?int $episodes = null,
        private ?string $youtubeTrailerId = null
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

    public function getEpisodes(): ?int
    {
        return $this->episodes;
    }

    public function setEpisodes(?int $episodes): void
    {
        $this->episodes = $episodes;
    }

    public function getYoutubeTrailerId(): ?string
    {
        return $this->youtubeTrailerId;
    }

    public function setYoutubeTrailerId(?string $youtubeTrailerId): void
    {
        $this->youtubeTrailerId = $youtubeTrailerId;
    }

    /**
     * Menghasilkan URL iframe YouTube untuk pemutar trailer pada modal detail.
     */
    public function getTrailerEmbedUrl(): ?string
    {
        if ($this->youtubeTrailerId === null || trim($this->youtubeTrailerId) === '') {
            return null;
        }
        return 'https://www.youtube.com/embed/' . rawurlencode($this->youtubeTrailerId);
    }

    /**
     * Override method abstrak dari class induk Media.
     */
    public function getMediaType(): string
    {
        return 'Anime';
    }

    /**
     * Override method abstrak untuk menampilkan ringkasan informasi kartu Anime.
     */
    public function getDetailsSummary(): string
    {
        $yearLabel = $this->year !== null ? (string) $this->year : 'Tahun belum tersedia';
        $episodeLabel = $this->episodes !== null ? "{$this->episodes} episode" : 'Episode belum tersedia';

        return "{$this->getMediaType()} · {$yearLabel} · {$episodeLabel}";
    }
}

