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
        Schema::table('users', function (Blueprint $table) {
            $table->string('facebook_id')->nullable()->unique()->after('google_id');
            $table->string('twitter_id')->nullable()->unique()->after('facebook_id');
            $table->string('linkedin_id')->nullable()->unique()->after('twitter_id');
            $table->string('github_id')->nullable()->unique()->after('linkedin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['facebook_id', 'twitter_id', 'linkedin_id', 'github_id']);
        });
    }
};
