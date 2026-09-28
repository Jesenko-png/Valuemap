<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->string('approval_status')->default('draft')->index();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
        });
        // Preserve existing public publications; never promote existing drafts.
        DB::table('content_items')->where('is_public', true)->where('status', '!=', 'draft')
            ->update(['approval_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('approved_by');
            $table->dropColumn(['approval_status', 'approved_at']);
        });
    }
};
