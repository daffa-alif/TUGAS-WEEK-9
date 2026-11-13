<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            return;
        }

        // User yang sudah ada sebelum role diperkenalkan dianggap pemilik aplikasi
        $existingUserIds = DB::table('users')->pluck('id');

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['Admin', 'Staff'])->default('Staff')->after('password');
        });

        DB::table('users')->whereIn('id', $existingUserIds)->update(['role' => 'Admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
