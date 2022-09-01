<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_percentages', function (Blueprint $table) {
            $table->id();
            $table->double('basic',8,2);
            $table->double('hra',8,2);
            $table->double('esi',8,2);
            $table->double('pf',8,2);
            $table->double('company_esi',8,2);
            $table->double('company_pf',8,2);
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
        Schema::dropIfExists('salary_percentages');
    }
}
