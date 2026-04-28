<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For MySQL, we use a raw statement to update the enum
        DB::statement("ALTER TABLE book_orders MODIFY COLUMN status ENUM('draft', 'submitted_by_school', 'approved_by_admin', 'processing_by_supplier', 'delivered_to_school', 'completed') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE book_orders MODIFY COLUMN status ENUM('draft', 'submitted_by_school', 'approved_by_admin', 'completed') DEFAULT 'draft'");
    }
};
