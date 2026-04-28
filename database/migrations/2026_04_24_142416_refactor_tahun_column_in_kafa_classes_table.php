<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ── Step 1: Backfill tahun + strip year prefix from name ─────────
        // Handles: "Tahun 1 Abu Bakar", "TAHUN 2 SIDDIQ", "1 Abu Bakar"
        DB::table('kafa_classes')->get()->each(function ($row) {
            $tahun     = $row->tahun;
            $cleanName = trim($row->name);

            if (!$tahun) {
                // Pattern A: "Tahun X Name" (case-insensitive, unicode)
                if (preg_match('/^tahun\s+(\d)\s+(.+)$/iu', $cleanName, $m)) {
                    $tahun     = (int) $m[1];
                    $cleanName = trim($m[2]);
                }
                // Pattern B: starts with single digit "1 Abu Bakar"
                elseif (preg_match('/^(\d)\s+(.+)$/', $cleanName, $m)) {
                    $tahun     = (int) $m[1];
                    $cleanName = trim($m[2]);
                }
            } else {
                // tahun already set — strip year from name if still embedded
                if (preg_match('/^tahun\s+\d+\s+(.+)$/iu', $cleanName, $m)) {
                    $cleanName = trim($m[1]);
                } elseif (preg_match('/^\d+\s+(.+)$/', $cleanName, $m)) {
                    $cleanName = trim($m[1]);
                }
            }

            DB::table('kafa_classes')->where('id', $row->id)->update([
                'tahun' => $tahun ? (int) $tahun : null,
                'name'  => $cleanName,
            ]);
        });

        // ── Step 2: Change column type string → tinyInteger ──────────────
        Schema::table('kafa_classes', function (Blueprint $table) {
            $table->tinyInteger('tahun')->unsigned()->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kafa_classes', function (Blueprint $table) {
            $table->string('tahun')->nullable()->change();
        });
    }
};
