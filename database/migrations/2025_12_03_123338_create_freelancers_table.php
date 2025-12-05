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
        Schema::create('freelancers', function (Blueprint $table) {
            // $table->id();

            /**
             * Relations ONE - TO - ONE
             * and i maked this column the PRIMARY ID
             */
            $table->foreignId('user_id')->primary()->constrained('users')->cascadeOnDelete();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('title')->nullable();
            $table->string('country');
            $table->boolean('verified')->default(0);
            $table->text('description')->nullable();
            $table->unsignedFloat('hourly_rate')->nullable();
            $table->string('profile_photo_path')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
