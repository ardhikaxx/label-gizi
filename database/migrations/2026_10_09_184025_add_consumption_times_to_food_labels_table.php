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
        Schema::table('food_labels', function (Blueprint $table) {
            $table->string('consumption_time_start', 10)->nullable()->after('consumption_limit_hours');
            $table->string('consumption_time_end', 10)->nullable()->after('consumption_time_start');
            $table->string('consumption_time_range', 100)->nullable()->after('consumption_time_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_labels', function (Blueprint $table) {
            $table->dropColumn(['consumption_time_start', 'consumption_time_end', 'consumption_time_range']);
        });
    }
};
