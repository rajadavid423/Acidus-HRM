<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('month');
            $table->decimal('gross',15,2);
            $table->decimal('working_days',15,1)->default(30);
            $table->decimal('days_present',15,1);
            $table->decimal('basic',15,2);
            $table->decimal('hra',15,2);
            $table->decimal('special_day_allowance',15,2)->default(0);
            $table->decimal('special_allowance',15,2)->default(0);
            $table->decimal('shift_allowance',15,2)->default(0);
            $table->decimal('other_allowance',15,2)->default(0);
            $table->decimal('total_earnings',15,2);
            $table->decimal('epf',15,2);
            $table->decimal('esi',15,2)->default(0);
            $table->decimal('tds_deduction',15,2)->default(0);
            $table->decimal('other_deduction',15,2)->default(0);
            $table->decimal('medi_claim',15,2)->default(0);
            $table->decimal('total_deduction',15,2);
            $table->decimal('company_epf',15,2);
            $table->decimal('company_esi',15,2);
            $table->decimal('net_salary',15,2);
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('ifsc_code');
            $table->longText('comments')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
