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
        if (Schema::hasTable('event_syllabuses')) {
            return;
        }

        Schema::create('event_syllabuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->index('idx_syllabus_event_id');
            $table->unsignedTinyInteger('module_number')->comment('Nomor urut sesi 1, 2, 3...');
            $table->string('title');
            $table->unsignedSmallInteger('duration')->default(90)->comment('Durasi sesi dalam menit');
            $table->text('description')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->unique(['event_id', 'module_number'], 'uk_event_module');
            $table->foreign('event_id', 'fk_syllabuses_event')
                ->references('id')->on('events')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_syllabuses');
    }
};
