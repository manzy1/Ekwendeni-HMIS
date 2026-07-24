<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ward_admissions', function (Blueprint $table) {
            $table->foreignId('patient_id')->constrained()->restrictOnDelete();
            $table->string('admission_number')->unique();
            $table->string('ward');
            $table->string('bed_number')->nullable();
            $table->dateTime('admitted_at');
            $table->string('diagnosis');
            $table->string('referring_facility')->nullable();
            $table->string('attending_clinician');
            $table->dateTime('discharged_at')->nullable();
            $table->string('final_diagnosis')->nullable();
            $table->text('treatment_given')->nullable();
            $table->string('outcome')->nullable();
            $table->string('discharge_destination')->nullable();
            $table->index(['ward', 'admitted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ward_admissions', function (Blueprint $table) {
            $table->dropColumn(['patient_id', 'admission_number', 'ward', 'bed_number', 'admitted_at', 'diagnosis', 'referring_facility', 'attending_clinician', 'discharged_at', 'final_diagnosis', 'treatment_given', 'outcome', 'discharge_destination']);
        });
    }
};
