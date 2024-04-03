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
        Schema::create('web_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('logo')->nullable();
            $table->text('zalo')->nullable();
            $table->text('google_map')->nullable();
            $table->text('google_analytic')->nullable();
            $table->text('facebook_id')->nullable();
            $table->text('youtube')->nullable();
            $table->text('tiktok')->nullable();
            $table->text('telegram')->nullable();
            $table->text('whats_app')->nullable();
            $table->text('dribble')->nullable();
            $table->text('pinterest')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_configs');
    }
};
