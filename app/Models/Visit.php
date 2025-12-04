<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visit extends Model
{
    protected $fillable = ['user_id', 'disease_id', 'symptoms_snapshot', 'notes'];

    // Relasi ke Pasien (User)
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Penyakit
    public function disease(): BelongsTo
    {
        return $this->belongsTo(Disease::class);
    }
}
