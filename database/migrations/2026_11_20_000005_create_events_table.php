<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_code', 20)->unique('uk_events_code');
            $table->string('title');
            $table->enum('category', ['Teknologi', 'Bisnis']);
            $table->text('description');
            $table->unsignedSmallInteger('session_duration')->default(90)->comment('Menit standar per sesi');
            $table->unsignedTinyInteger('total_sessions')->default(1);
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Published');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['category', 'status'], 'idx_events_category_status');
            $table->index('category', 'idx_events_category');
            $table->index('status', 'idx_events_status');
            $table->fullText(['title', 'description'], 'ft_events_search');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
