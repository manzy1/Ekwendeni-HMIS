<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyPlanningVisit extends Model
{
    protected $fillable = ['patient_id','visit_date','monthly_serial_number','client_category','parity','living_children','marital_status','hiv_status','art_status','previous_method','current_method','visit_type','discontinued','side_effects','next_appointment','provider','comments'];
    protected function casts(): array { return ['visit_date' => 'date', 'next_appointment' => 'date', 'discontinued' => 'boolean']; }
    public function patient(): BelongsTo { return $this->belongsTo(Patient::class); }
}
