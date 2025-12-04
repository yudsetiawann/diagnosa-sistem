<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    /** @use HasFactory<\Database\Factories\PatientFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'age', 'gender', 'address', 'phone'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function diagnoses()
    {
        return $this->hasMany(PatientDiagnosis::class);
    }
}
