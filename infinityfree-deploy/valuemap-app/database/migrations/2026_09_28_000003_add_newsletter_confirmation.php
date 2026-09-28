<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->timestamp('confirmed_at')->nullable()->after('consent_at');
            $table->timestamp('unsubscribed_at')->nullable()->after('confirmed_at');
        });

        // Registrations made before double opt-in was introduced remain active.
        DB::table('newsletter_subscribers')->update(['confirmed_at' => DB::raw('consent_at')]);
    }

    public function down(): void
    {
        Schema::table('newsletter_subscribers', function (Blueprint $table) {
            $table->dropColumn(['confirmed_at', 'unsubscribed_at']);
        });
    }
};
