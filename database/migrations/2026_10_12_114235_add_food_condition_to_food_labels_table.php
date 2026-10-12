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
            $table->string('food_condition', 50)->default('Porsi besar')->after('menu_date')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('food_labels', function (Blueprint $table) {
            $table->dropColumn('food_condition');
        });
    }
};
