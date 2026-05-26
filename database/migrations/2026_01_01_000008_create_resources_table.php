<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['bibliotheque', 'cours', 'sujets', 'orientation', 'outils'])->default('cours');
            $table->string('file_url')->nullable();
            $table->string('external_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_public')->default(false); // false = membres uniquement
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
