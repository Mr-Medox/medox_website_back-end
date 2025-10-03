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
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('price');
            $table->string('duration', 100)->nullable();
            $table->json('features')->nullable();
            $table->boolean('popular')->default(false);
            $table->boolean('published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['published', 'popular']);
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_packages');
    }
};
