<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsMethodTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments_methods', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnUpdate()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('payments_methods');
    }
}
