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
        Schema::create('loan_repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->onDelete('cascade')->after('id');
            $table->date('payment_date')->nullable();
            $table->decimal('interest_amount', 10,2)->default(0.00);
            $table->decimal('repayment_amount', 10,2)->default(0.00);
            $table->decimal('paid_amount', 10,2)->default(0.00);
            $table->string('log')->nullable();
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
        Schema::dropIfExists('loan_repayments');
    }
};
