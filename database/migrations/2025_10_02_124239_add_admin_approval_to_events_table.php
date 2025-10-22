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
        Schema::table('events', function (Blueprint $table) {
            // Changer les statuts possibles pour inclure l'approbation
            $table->enum('status', ['draft', 'pending', 'published', 'rejected', 'cancelled', 'completed'])->default('draft')->change();
            
            // Ajouter les champs d'approbation admin
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('created_by');
            $table->datetime('approved_at')->nullable()->after('approved_by');
            $table->text('rejection_reason')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['approved_by', 'approved_at', 'rejection_reason']);
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])->default('draft')->change();
        });
    }
};
