<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('member_number')->unique(); // ex: UFEEL-2026-0001
            $table->enum('status', ['pending', 'active', 'inactive', 'suspended'])->default('pending');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['homme', 'femme', 'autre'])->nullable();
            $table->string('city')->nullable();
            $table->string('school_or_university')->nullable();
            $table->enum('level', ['eleve', 'etudiant', 'autre'])->default('eleve');
            $table->text('bio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
