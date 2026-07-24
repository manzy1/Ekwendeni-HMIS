<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpdVisit extends Model
{
    protected $fillable = ['patient_id','visit_date','age_group','chief_complaint','diagnosis','icd10_code','treatment','referral','outcome','provider'];
    protected function casts(): array { return ['visit_date' => 'date']; }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
