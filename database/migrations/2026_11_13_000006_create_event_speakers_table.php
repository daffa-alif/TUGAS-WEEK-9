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
        if (Schema::hasTable('event_speakers')) {
            return;
        }

        Schema::create('event_speakers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('speaker_id');
            $table->unsignedBigInteger('syllabus_id')->nullable();
            $table->string('role_topic', 150)->nullable()->default('Keynote Speaker');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->foreign('event_id', 'fk_es_event')
                ->references('id')->on('events')
                ->cascadeOnDelete();
            $table->foreign('speaker_id', 'fk_es_speaker')
                ->references('id')->on('speakers')
                ->cascadeOnDelete();
            $table->foreign('syllabus_id', 'fk_es_syllabus')
                ->references('id')->on('event_syllabuses')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_speakers');
    }
};
