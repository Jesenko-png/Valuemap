<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 32);
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('reference_code')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('partner')->nullable();
            $table->date('published_at')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('status', 32)->default('published');
            $table->string('category')->nullable();
            $table->string('file_path')->nullable();
            $table->string('external_url')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_public')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['type', 'is_public', 'published_at'], 'idx_content_type_visibility');
            $table->index(['status', 'sort_order'], 'idx_content_status_sort');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_items');
    }
};
