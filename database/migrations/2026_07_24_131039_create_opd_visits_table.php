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
        Schema::create('opd_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->restrictOnDelete();
            $table->date('visit_date');
            $table->string('age_group', 10);
            $table->text('chief_complaint')->nullable();
            $table->string('diagnosis');
            $table->string('icd10_code')->nullable();
            $table->text('treatment')->nullable();
            $table->string('referral')->nullable();
            $table->string('outcome')->default('Treated');
            $table->string('provider');
            $table->index(['visit_date', 'diagnosis']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_visits');
    }
};
