<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('duration');
            $table->string('leave_type');
            $table->double('no_of_days',8,1);
            $table->string('reason');
            $table->string('status')->default('Pending');
            $table->string('reject_reason')->nullable();
            $table->double('cl_count',8,1)->default(0);
            $table->double('sl_count',8,1)->default(0);
            $table->double('pl_count',8,1)->default(0);
            $table->double('loss_of_pay_count',8,1)->default(0);
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
        Schema::dropIfExists('leaves');
    }
}
