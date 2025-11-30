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
        Schema::create('categories', function (Blueprint $table) {
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // $table->unsignedBigInteger('id')->autoIncrement()->primary();
            // (unsigned) that mean the index of (id) is can not been (minos of number (-1 or down))
            // the id is started in 0 or what the developer need
            // $table->bigIncrements('id')->primary();
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('art_path')->nullable();
            // $table->unsignedBigInteger('parent_id')->nullable(); // can be null
            // $table->foreign('parent_id')->references('id')->on('categories')//->cascadeOnDelete() // when the parent delete the child is delete
            //->restrictOnDelete() // when the parent delete and have a child can not delete the parent
            // ->nullOnDelete(); // when the parent delete the child is null

            $table->foreignId('parent_id')->nullable()->constrained('categories', 'id')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
