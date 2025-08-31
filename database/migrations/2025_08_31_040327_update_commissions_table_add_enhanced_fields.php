<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Added missing import

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commissions', function (Blueprint $table) {
            // Add new fields for enhanced commission system
            $table->string('work_type')->nullable()->after('artist_id');
            $table->date('deadline')->nullable()->after('work_type');
            $table->decimal('budget_min', 10, 2)->nullable()->after('deadline');
            $table->decimal('budget_max', 10, 2)->nullable()->after('budget_min');
            $table->text('references')->nullable()->after('budget_max');
            $table->timestamp('accepted_at')->nullable()->after('status');
            $table->timestamp('completed_at')->nullable()->after('accepted_at');
            $table->text('artist_message')->nullable()->after('completed_at');
            $table->text('client_message')->nullable()->after('artist_message');
        });

        // Update the status enum to include new statuses
        DB::statement("ALTER TABLE commissions MODIFY COLUMN status ENUM('pending', 'accepted', 'in_progress', 'completed', 'rejected', 'cancelled') DEFAULT 'pending'");
        
        // Remove artwork_id column if it exists
        if (Schema::hasColumn('commissions', 'artwork_id')) {
            Schema::table('commissions', function (Blueprint $table) {
                $table->dropForeign(['artwork_id']);
                $table->dropColumn('artwork_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commissions', function (Blueprint $table) {
            // Remove new fields
            $table->dropColumn([
                'work_type',
                'deadline', 
                'budget_min',
                'budget_max',
                'references',
                'accepted_at',
                'completed_at',
                'artist_message',
                'client_message'
            ]);
        });

        // Revert status enum
        DB::statement("ALTER TABLE commissions MODIFY COLUMN status ENUM('pending', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending'");
        
        // Add back artwork_id field
        Schema::table('commissions', function (Blueprint $table) {
            $table->foreignId('artwork_id')->nullable()->after('artist_id')->constrained()->onDelete('cascade');
        });
    }
};
