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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('tel');
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->string('avatar')->nullable();
            $table->string('favori_kitap')->nullable();
            $table->string('favori_kategori')->nullable();
            $table->rememberToken(); 
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
        });

       

        
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');    
    }
};
