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
        Schema::create('hospital_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hospital_name');
            $table->string('hospital_code')->nullable()->unique();
            $table->string('district')->nullable();
            $table->string('country')->default('Malawi');
            $table->unsignedTinyInteger('reporting_year_starts_month')->default(4);
            $table->string('timezone')->default('Africa/Blantyre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_settings');
    }
};
