<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('pay_term');
            $table->decimal('opening_cl',8,1);
            $table->decimal('opening_sl',8,1);
            $table->decimal('opening_pl',8,1);
            $table->decimal('consumed_cl',8,1)->nullable();
            $table->decimal('consumed_sl',8,1)->nullable();
            $table->decimal('consumed_pl',8,1)->nullable();
            $table->decimal('closing_cl',8,1)->nullable();
            $table->decimal('closing_sl',8,1)->nullable();
            $table->decimal('closing_pl',8,1)->nullable();
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
        Schema::dropIfExists('leave_records');
    }
}
