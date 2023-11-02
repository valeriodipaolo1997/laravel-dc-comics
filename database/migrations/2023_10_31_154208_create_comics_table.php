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
        Schema::create('comics', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->text('description')->nullable();
            $table->text('thumb')->nullable();
            $table->string('price', 11)->nullable();
            $table->string('series', 100);
            $table->date('sale_date')->nullable();
            $table->string('artists', 255)->nullable();
            $table->string('writers', 255)->nullable();
            $table->tinyInteger('is_available')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comics');
    }
};
