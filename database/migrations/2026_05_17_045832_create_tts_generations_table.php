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
        Schema::create('tts_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('input_text');
            $table->string('model');
            $table->string('voice')->nullable();
            $table->string('response_format')->default('mp3');
            $table->decimal('speed', 4, 2)->default(1.0);
            $table->string('audio_file_path')->nullable();
            $table->string('generation_id')->nullable();
            $table->decimal('credits_spent', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tts_generations');
    }
};
