<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'unsubscribed'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->enum('type', ['institutionnel', 'entreprise', 'ong', 'media'])->default('entreprise');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('display_order')->default(0);
            $table->timestamps();
        });

        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('session_token')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('messages')->default('[]');
            $table->timestamps();
        });

        Schema::create('site_stats', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // membres_actifs, activites, jeunes_formes, partenaires
            $table->unsignedInteger('value')->default(0);
            $table->string('label');
            $table->string('icon')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_stats');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('newsletter_subscribers');
    }
};
