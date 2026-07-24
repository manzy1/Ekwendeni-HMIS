<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalSetting extends Model
{
    protected $fillable = [
        'hospital_name',
        'hospital_code',
        'district',
        'country',
        'reporting_year_starts_month',
        'timezone',
    ];

    protected function casts(): array
    {
        return [
            'reporting_year_starts_month' => 'integer',
        ];
    }
}
