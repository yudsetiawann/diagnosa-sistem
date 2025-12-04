<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    /** @use HasFactory<\Database\Factories\DiseaseFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description'];
    public function symptoms()
    {
        return $this->belongsToMany(Symptom::class);
    }
    public function diagnoses()
    {
        return $this->hasMany(PatientDiagnosis::class);
    }
}
