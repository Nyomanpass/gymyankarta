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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('transaction_datetime');
            $table->enum('transaction_type', ['membership_payment', 'daily_visit_fee', 'additional_items_sale']);
            $table->text('description')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payment_method');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
