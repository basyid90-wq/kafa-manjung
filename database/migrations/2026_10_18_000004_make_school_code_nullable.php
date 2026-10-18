<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Self-registered workspaces have no official school code. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('code')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Left nullable: rows created by self-signup would violate NOT NULL.
    }
};
