<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->string('type')->nullable();
            $table->string('description');
            $table->unsignedBigInteger('status_id');
            $table->date('expected_date')->nullable();
            $table->boolean('paid')->default(0);
            $table->date('paid_at')->nullable();
            $table->string('paid_by')->nullable();
            $table->decimal('amount')->default(0);
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('contract_payment_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
