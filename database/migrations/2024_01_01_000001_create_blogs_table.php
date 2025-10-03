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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('published')->default(false);
            $table->boolean('featured')->default(false);
            $table->string('category');
            $table->json('tags')->nullable();
            $table->integer('read_time')->default(5);
            $table->integer('views')->default(0);
            $table->integer('seo_score')->default(0);
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->index(['published', 'featured']);
            $table->index('category');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
