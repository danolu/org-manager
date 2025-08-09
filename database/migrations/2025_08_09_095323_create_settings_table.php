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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenure');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('id_name')->nullable();
            $table->date('election_start')->nullable();
            $table->date('election_end')->nullable();
            $table->boolean('is_election_time')->default(false);
            $table->boolean('is_registration_open')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
