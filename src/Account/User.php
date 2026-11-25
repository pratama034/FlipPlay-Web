<?php

declare(strict_types=1);

namespace FlipPlay\Engine\Account;

use FlipPlay\Engine\Collection\UserLibrary;

/**
 * Class User merepresentasikan akun pelanggan FlipPlay.
 * Menerapkan relasi Composition dengan UserLibrary (setiap User memiliki satu UserLibrary).
 */
class User
{
    /**
     * Objek koleksi milik pengguna (Relasi Composition).
     */
    private UserLibrary $library;

    /**
     * Constructor dengan Constructor Property Promotion PHP 8.
     *
     * @param int $id ID unik pengguna
     * @param string $name Nama lengkap pelanggan
     * @param string $email Alamat email akun FlipPlay
     * @param string $subscriptionPlan Paket langganan ("Biasa", "Pro", "Premium")
     */
    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private string $subscriptionPlan = 'Biasa'
    ) {
        $initialCapacity = $this->resolveCapacityByPlan($this->subscriptionPlan);
        $this->library = new UserLibrary($initialCapacity);
    }

    /**
     * Menentukan kapasitas maksimal simpanan library berdasarkan paket langganan.
     */
    private function resolveCapacityByPlan(string $plan): ?int
    {
        return match (strtolower(trim($plan))) {
            'biasa' => 10,
            'pro' => 50,
            'premium' => null, // Tidak terbatas (Unlimited)
            default => 5,
        };
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSubscriptionPlan(): string
    {
        return $this->subscriptionPlan;
    }

    /**
     * Mengubah atau meningkatkan paket langganan pengguna dan menyesuaikan kapasitas library.
     */
    public function upgradePlan(string $newPlan): void
    {
        $this->subscriptionPlan = $newPlan;
        $this->library->setMaxCapacity($this->resolveCapacityByPlan($newPlan));
    }

    /**
     * Mengembalikan objek UserLibrary milik pengguna.
     */
    public function getLibrary(): UserLibrary
    {
        return $this->library;
    }

    /**
     * Menghasilkan ringkasan profil pengguna beserta status kapasitas koleksinya.
     */
    public function getProfileSummary(): string
    {
        $maxCap = $this->library->getMaxCapacity();
        $capacityLabel = $maxCap === null ? 'Unlimited' : (string) $maxCap;

        return sprintf(
            'User #%d: %s (%s) | Paket: %s | Koleksi: %d/%s item',
            $this->id,
            $this->name,
            $this->email,
            $this->subscriptionPlan,
            $this->library->count(),
            $capacityLabel
        );
    }
}

