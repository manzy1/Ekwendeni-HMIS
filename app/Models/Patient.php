<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    protected $fillable = ['national_id', 'first_name', 'last_name', 'age', 'sex', 'village', 'phone_number', 'status'];

    protected static function booted(): void
    {
        static::creating(function (Patient $patient): void {
            $patient->hospital_number ??= sprintf('EMH-%s-%06d', now()->year, (static::max('id') ?? 0) + 1);
        });
    }

    public function scopeSearch(Builder $query, ?string $term): void
    {
        if (blank($term)) return;
        $query->where(fn (Builder $q) => $q->where('hospital_number', 'like', "%{$term}%")->orWhere('national_id', 'like', "%{$term}%")->orWhere('first_name', 'like', "%{$term}%")->orWhere('last_name', 'like', "%{$term}%")->orWhere('phone_number', 'like', "%{$term}%"));
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function familyPlanningVisits(): HasMany { return $this->hasMany(FamilyPlanningVisit::class); }

    public function opdVisits(): HasMany { return $this->hasMany(OpdVisit::class); }

    public function wardAdmissions(): HasMany { return $this->hasMany(WardAdmission::class); }
}
