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
        Schema::create('book_copies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->string('barcode')->unique();
            $table->string('shelf_location')->nullable();
            $table->string('condition')->default('Yeni');
            $table->enum('status', ['available', 'borrowed', 'reserved', 'lost'])->default('available');
            $table->boolean('is_reference')->default(false);
            $table->date('acquisition_date')->nullable();
            $table->string('acquisition_source')->nullable();
            $table->integer('acquisition_cost')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('notes')->nullable();
            $table->dateTimeTz('created_at');
            $table->dateTimeTz('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_copies');
    }
};
