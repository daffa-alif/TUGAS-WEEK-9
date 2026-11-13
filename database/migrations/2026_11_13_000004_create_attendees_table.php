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
        if (Schema::hasTable('attendees')) {
            return;
        }

        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 150);
            $table->string('email', 150)->unique('email');
            $table->string('phone', 25)->nullable();
            $table->string('institution', 150)->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendees');
    }
};
