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
        Schema::table('shop_requests', function (Blueprint $table) {
            $table->timestamp('processed_at')->nullable()->after('status');
            $table->unsignedBigInteger('processed_by')->nullable()->after('processed_at');
            $table->text('rejection_reason')->nullable()->after('processed_by');
            
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shop_requests', function (Blueprint $table) {
            $table->dropForeign(['processed_by']);
            $table->dropColumn(['processed_at', 'processed_by', 'rejection_reason']);
        });
    }
};
