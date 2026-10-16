<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->string('location')->nullable()->after('event_date');
            $table->string('target_audience')->nullable()->after('location');
            $table->string('registration_url', 500)->nullable()->after('target_audience');
            $table->string('agenda_url', 500)->nullable()->after('registration_url');
            $table->text('related_resources')->nullable()->after('agenda_url');
        });
    }

    public function down(): void
    {
        Schema::table('content_items', function (Blueprint $table) {
            $table->dropColumn(['location', 'target_audience', 'registration_url', 'agenda_url', 'related_resources']);
        });
    }
};
