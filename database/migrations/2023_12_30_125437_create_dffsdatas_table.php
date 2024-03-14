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
        Schema::create('dffsdatas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId');
            $table->string('ipfsHash');
            $table->timestamps();
            
         $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dffsdatas');
    }
};
