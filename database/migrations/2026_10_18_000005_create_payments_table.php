<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('plan', 20);
            $table->unsignedTinyInteger('months')->default(1);
            $table->decimal('amount', 10, 2);
            $table->string('order_number', 40)->unique();
            $table->string('status', 20)->default('pending');   // pending | paid | failed | cancelled
            $table->string('gateway', 20)->default('bayarcash');
            $table->string('gateway_intent_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('exchange_reference_number')->nullable();
            $table->string('payer_bank_name')->nullable();
            $table->string('status_description')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            $table->timestamps();

            $table->index(['school_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
