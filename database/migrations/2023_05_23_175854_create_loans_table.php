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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('mobile_no')->nullable();
            $table->integer('alternative_no')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('address')->nullable();
            $table->foreignId('area_id')->nullable();
            $table->string('contact_person')->nullable();
            $table->integer('contact_person_no')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('final_amount', 10, 2)->nullable();
            $table->integer('interest_rate')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->foreignId('agent_id')->nullable();
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
        Schema::dropIfExists('loans');
    }
};
