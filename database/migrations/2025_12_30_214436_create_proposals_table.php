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
        /**
         * this table is a pivot table (جدول وسيط) freelancer and project
         */
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            /**
             * Foreign Keys
             * - freelancer_id references users(id)
             * - project_id references projects(id)
             */
            $table->foreignId('freelancer_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->foreignId('project_id')->constrained('projects', 'id')->cascadeOnDelete();

            $table->text('description');
            $table->unsignedFloat('cost');
            $table->unsignedInteger('duration');
            $table->enum('duration_unit', ['day', 'week', 'month', 'year']);
            $table->enum('status', ['pending', 'accepted', 'declined']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
