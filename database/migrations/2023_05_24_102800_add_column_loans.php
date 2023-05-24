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
        Schema::table('loans', function(Blueprint $table){
            $table->string('loan_no')->nullable()->after('id');
            $table->date('loan_date')->nullable()->after('interest_rate');
            $table->integer('emi_day')->nullable()->after('loan_date');
            $table->integer('period')->nullable()->after('emi_day');
            $table->renameColumn('amount', 'loan_amount');
            $table->dropColumn('amount_in_words');
            $table->decimal('paid_amout', 10,2)->nullable()->before('agent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
