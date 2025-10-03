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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('features')->nullable();
            $table->string('price', 100)->nullable();
            $table->string('category', 100);
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('icon', 100)->nullable();
            $table->json('benefits')->nullable();
            $table->timestamps();

            $table->index(['published', 'featured']);
            $table->index('category');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
