<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('partners')) {
            return;
        }

        DB::table('partners')
            ->where('name', 'InnoStars')
            ->update([
                'country' => 'Germany',
                'country_code' => 'DEU',
                'location' => 'Munich',
                'latitude' => 48.1351,
                'longitude' => 11.5820,
                'updated_at' => now(),
            ]);

        DB::table('partners')
            ->where('name', 'like', 'Takeda%')
            ->update([
                'name' => 'Takeda',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('partners')) {
            return;
        }

        DB::table('partners')
            ->where('name', 'InnoStars')
            ->update([
                'country' => 'Hungary',
                'country_code' => 'HUN',
                'location' => 'Hungary',
                'latitude' => 47.4979,
                'longitude' => 19.0402,
                'updated_at' => now(),
            ]);

        DB::table('partners')
            ->where('name', 'Takeda')
            ->update([
                'name' => 'Takeda Products Ireland Ltd.',
                'updated_at' => now(),
            ]);
    }
};
