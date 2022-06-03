<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('type')->nullable(); // NORMAL, VIP, BOLSA
            $table->date('start_date')->nullable();
            $table->integer('payment_due_date')->nullable();
            $table->decimal('payment_monthly_value', 8, 2)->default(0);
            $table->decimal('payment_registration_value', 8, 2)->default(0);
            $table->integer('payment_quantity')->nullable();
            $table->decimal('payment_total', 8, 2)->default(0);

            $table->integer('school_days')->default(1);

            $table->bigInteger('student_id')->unsigned()->nullable();
            $table->bigInteger('group_classes_id')->unsigned()->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->bigInteger('payments_method_id')->unsigned()->nullable();

            $table->string('observations')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('students')->onDelete('NO ACTION')->cascadeOnUpdate();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('SET NULL')->cascadeOnUpdate();
            $table->foreign('group_classes_id')->references('id')->on('group_classes')->onDelete('SET NULL')->cascadeOnUpdate();
            $table->foreign('payments_method_id')->references('id')->on('payments_methods')->onDelete('SET NULL')->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
