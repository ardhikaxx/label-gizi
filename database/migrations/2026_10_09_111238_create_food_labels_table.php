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
        Schema::create('food_labels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->date('menu_date')->index();
            $table->string('recipient_group')->nullable();
            $table->text('description')->nullable();
            $table->decimal('energy', 8, 2)->default(0); // kkal
            $table->decimal('protein', 8, 2)->default(0); // gram
            $table->decimal('fat', 8, 2)->default(0); // gram
            $table->decimal('carbohydrate', 8, 2)->default(0); // gram
            $table->decimal('fiber', 8, 2)->default(0); // gram
            $table->decimal('consumption_limit_hours', 4, 1)->default(4.0); // jam setelah pengantaran
            $table->string('status', 20)->default('draft')->index(); // draft, scheduled, published, archived
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'menu_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_labels');
    }
};
