<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 30)->default('reader')->after('is_admin');
            $table->string('requested_role', 30)->nullable()->after('role');
            $table->boolean('is_approved')->default(false)->after('requested_role');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
            $table->foreignId('approved_by')->nullable()->after('approved_at')->constrained('users')->nullOnDelete();
        });

        // Preserve access for accounts that existed before approval workflows.
        DB::table('users')->update(['is_approved' => true]);
        DB::table('users')->where('is_admin', true)->update([
            'role' => 'main_admin',
            'requested_role' => 'main_admin',
            'is_approved' => true,
            'approved_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['role', 'requested_role', 'is_approved', 'approved_at', 'approved_by']);
        });
    }
};
