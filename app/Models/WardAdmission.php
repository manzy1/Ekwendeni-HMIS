<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WardAdmission extends Model
{
    protected $fillable = ['patient_id','admission_number','ward','bed_number','admitted_at','diagnosis','referring_facility','attending_clinician','discharged_at','final_diagnosis','treatment_given','outcome','discharge_destination'];
    protected function casts(): array { return ['admitted_at' => 'datetime', 'discharged_at' => 'datetime']; }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
