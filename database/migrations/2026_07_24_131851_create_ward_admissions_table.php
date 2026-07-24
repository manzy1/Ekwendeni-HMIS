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
        Schema::create('ward_admissions', function (Blueprint $table) {
            $table->id();
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ward_admissions');
    }
};
