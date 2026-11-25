<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'title',
        'type',
        'genre',
        'release_year',
        'total_units',
        'status',
        'description',
    ];

    protected $casts = [
        'release_year' => 'integer',
        'total_units' => 'integer',
    ];

    /**
     * Users yang menyimpan media ini di dalam koleksi mereka.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
