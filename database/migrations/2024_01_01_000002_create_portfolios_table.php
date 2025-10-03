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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('featured_image');
            $table->json('gallery')->nullable();
            $table->string('category');
            $table->string('industry')->nullable();
            $table->json('technologies')->nullable();
            $table->json('features')->nullable();
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('views')->default(0);
            $table->string('project_duration')->nullable();
            $table->string('project_budget')->nullable();
            $table->string('client_name')->nullable();
            $table->text('results')->nullable();
            $table->text('challenge')->nullable();
            $table->text('solution')->nullable();
            $table->text('impact')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['published', 'featured']);
            $table->index(['category', 'industry']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
