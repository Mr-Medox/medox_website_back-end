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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('company');
            $table->text('content');
            $table->integer('rating')->default(5);
            $table->string('project')->nullable();
            $table->foreignId('project_id')->nullable()->constrained('portfolios')->onDelete('set null');
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->index(['published', 'featured']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
