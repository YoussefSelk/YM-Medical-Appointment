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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('details');
            $table->string('cv');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('registration_token')->nullable();
            $table->timestamp('token_expiry')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
