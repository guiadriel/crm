<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeOnStudentLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_logs', function (Blueprint $table) {
            $table->string('type')->nullable()->default('SISTEMA');
            $table->unsignedBigInteger('status_id')->nullable()->index()->after('student_id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->text('reason_cancellation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_logs', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('status_id');
            $table->dropColumn('contract_id');
            // $table->dropColumn('reason_cancellation');
        });
    }
}
