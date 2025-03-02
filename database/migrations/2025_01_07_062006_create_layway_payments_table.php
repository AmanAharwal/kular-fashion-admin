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
        Schema::create('layway_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layway_id')->index();
            $table->unsignedBigInteger('customer_id')->index();
            $table->decimal('balance', 15, 2);
            $table->decimal('amount_paid', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layway_payments');
    }
};
