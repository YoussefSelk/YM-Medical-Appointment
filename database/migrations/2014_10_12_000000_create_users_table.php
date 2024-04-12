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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender');
            $table->string('phone');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->string('user_type');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('img')->nullable(); // Add this line for the profile picture
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('address_id')->references('id')->on('addresses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
