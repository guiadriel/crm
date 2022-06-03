<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contract_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->integer('sequence')->nullable();
            $table->date('due_date')->nullable();
            $table->string('type')->nullable();
            $table->decimal('value', 8, 2)->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign('student_id')->references('id')->on('students')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('contract_payments');
    }
}
