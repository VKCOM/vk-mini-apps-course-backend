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
        Schema::table('achievements', function(Blueprint $table) {
            $table->string('code')->unique();
            $table->string('story_img');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievements', function(Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('story_img');
        });
    }
};
