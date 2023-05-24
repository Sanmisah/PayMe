<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_repayment_id')->constrained('loan_repayments')->onDelete('cascade');
            $table->date('payment_date')->nullable();
            $table->decimal('travelling_charges', 10,2)->defauft(0.000);
            $table->decimal('interest_received_amount', 10,2)->defauft(0.000);
            $table->decimal('loan_received_amount', 10,2)->defauft(0.000);
            $table->string('payment_mode')->nullable();
            $table->string('utr_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
