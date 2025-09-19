<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update any existing 'seller' role to 'user'
        DB::table('users')->where('role', 'seller')->update(['role' => 'user']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse operation: convert user back to seller
        // (This is for rollback purposes, though we don't really want sellers anymore)
        DB::table('users')->where('role', 'user')->update(['role' => 'seller']);
    }
};
