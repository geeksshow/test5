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
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->string('brand');
            $table->string('processor');
            $table->string('ram');
            $table->string('storage');
            $table->string('display');
            $table->string('graphics');
            $table->string('operating_system');
            $table->string('color');
            $table->integer('stock_quantity')->default(0);
            $table->string('image')->nullable();
            $table->json('images')->nullable(); // Multiple images
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
