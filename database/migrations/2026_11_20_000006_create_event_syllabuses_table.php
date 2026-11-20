<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('event_syllabuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedTinyInteger('module_number')->comment('Nomor urut sesi 1, 2, 3...');
            $table->string('title');
            $table->unsignedSmallInteger('duration')->default(90)->comment('Durasi sesi dalam menit');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->unique(['event_id', 'module_number'], 'uk_event_module');
            $table->index('event_id', 'idx_syllabus_event_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_syllabuses');
    }
};
