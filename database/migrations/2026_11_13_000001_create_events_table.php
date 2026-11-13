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
        // Tabel sudah dibuat manual di beberapa environment, jangan timpa datanya
        if (Schema::hasTable('events')) {
            return;
        }

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_code', 20)->unique('uk_events_code');
            $table->string('title');
            $table->enum('category', ['Teknologi', 'Bisnis'])->index('idx_events_category');
            $table->text('description');
            $table->unsignedSmallInteger('session_duration')->default(90)->comment('Menit standar per sesi');
            $table->unsignedTinyInteger('total_sessions')->default(1);
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Published')->index('idx_events_status');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();

            $table->index(['category', 'status'], 'idx_events_category_status');
            $table->fullText(['title', 'description'], 'ft_events_search');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
