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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('book_name');
            $table->string('author');
            $table->integer('page_count');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('isbn');
            $table->string('publisher');
            $table->integer('publish_year');
            $table->string('status');
            $table->string('book_cover')->nullable(); // Ensure this line is included
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
