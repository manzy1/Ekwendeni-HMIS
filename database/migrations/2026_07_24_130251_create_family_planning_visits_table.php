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
        Schema::create('family_planning_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->restrictOnDelete();
            $table->date('visit_date');
            $table->unsignedInteger('monthly_serial_number');
            $table->string('client_category')->nullable();
            $table->unsignedTinyInteger('parity')->nullable();
            $table->unsignedTinyInteger('living_children')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('hiv_status')->nullable();
            $table->string('art_status')->nullable();
            $table->string('previous_method')->nullable();
            $table->string('current_method');
            $table->string('visit_type');
            $table->boolean('discontinued')->default(false);
            $table->text('side_effects')->nullable();
            $table->date('next_appointment')->nullable();
            $table->string('provider')->nullable();
            $table->text('comments')->nullable();
            $table->unique(['visit_date', 'monthly_serial_number']);
            $table->index(['visit_date', 'current_method']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_planning_visits');
    }
};
