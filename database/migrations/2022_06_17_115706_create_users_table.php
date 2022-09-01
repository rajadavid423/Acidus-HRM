<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('designation_id')->nullable();
            $table->string('employee_id');
            $table->foreignId('shift_id')->nullable();
            $table->date('dob')->nullable();
            $table->foreignId('process_id')->nullable();
            $table->string('gender')->nullable();
            $table->foreignId('team_id')->nullable();
            $table->foreignId('client_id')->nullable();
            $table->foreignId('branch_id')->nullable();
            $table->bigInteger('phone_number')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('esi_number')->nullable();
            $table->string('uan_number')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->date('date_of_leaving')->nullable();
            $table->decimal('cl',8,1)->default(0);
            $table->decimal('sl',8,1)->default(0);
            $table->decimal('pl',8,1)->default(0);
            $table->decimal('salary',15,2)->nullable();
            $table->decimal('gross',15,2)->nullable();
            $table->decimal('basic',15,2)->nullable();
            $table->decimal('hra',15,2)->nullable();
            $table->decimal('esi',15,2)->nullable();
            $table->decimal('pf',15,2)->nullable();
            $table->decimal('insurance',15,2)->nullable();
            $table->decimal('net_amount',15,2)->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
