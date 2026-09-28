<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('initials', 20);
            $table->string('country');
            $table->string('country_code', 3);
            $table->string('location')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->decimal('map_offset_x', 7, 2)->default(0);
            $table->decimal('map_offset_y', 7, 2)->default(0);
            $table->string('role')->nullable();
            $table->text('description')->nullable();
            $table->string('website_url', 500)->nullable();
            $table->string('logo_path')->nullable();
            $table->json('contacts')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $countryCodes = ['Hungary' => 'HUN', 'Spain' => 'ESP', 'Portugal' => 'PRT', 'Sweden' => 'SWE', 'Bosnia and Herzegovina' => 'BIH', 'Ireland' => 'IRL'];
        $now = now();
        $partners = collect(config('valuemap.partners'))->values()->map(fn (array $partner, int $index) => [
            'name' => $partner['name'],
            'initials' => $partner['initials'],
            'country' => $partner['country'],
            'country_code' => $partner['country_code'] ?? $countryCodes[$partner['country']],
            'location' => $partner['location'] ?? null,
            'latitude' => $partner['latitude'],
            'longitude' => $partner['longitude'],
            'map_offset_x' => $partner['map_offset_x'] ?? 0,
            'map_offset_y' => $partner['map_offset_y'] ?? 0,
            'role' => $partner['role'] ?? null,
            'description' => $partner['description'] ?? null,
            'website_url' => $partner['url'] ?? null,
            'logo_path' => null,
            'contacts' => json_encode([]),
            'sort_order' => $index + 1,
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
        ])->all();

        DB::table('partners')->insert($partners);
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
