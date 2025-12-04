<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDiagnosis extends Model
{
    /** @use HasFactory<\Database\Factories\PatientDiagnosisFactory> */
    use HasFactory;
    protected $fillable = ['patient_id', 'disease_id', 'date', 'notes'];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
