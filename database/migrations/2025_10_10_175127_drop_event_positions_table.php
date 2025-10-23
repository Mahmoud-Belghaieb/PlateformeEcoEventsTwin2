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
        Schema::dropIfExists('event_positions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate the table if migration is rolled back
        Schema::create('event_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->foreignId('position_id')->constrained()->onDelete('cascade');
            $table->integer('required_count');
            $table->integer('filled_count')->default(0);
            $table->decimal('event_specific_rate', 8, 2)->nullable();
            $table->text('additional_requirements')->nullable();
            $table->datetime('application_deadline')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['event_id', 'position_id']);
        });
    }
};
