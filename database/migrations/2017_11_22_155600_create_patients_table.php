<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name');
			$table->date('dob')->nullable();
            $table->string('email')->unique();
            $table->string('avatar')->default('no-image.png');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
			$table->string('insurance_name')->nullable();
            $table->string('insurance_type')->nullable();
            $table->string('insurance_number')->nullable();
			$table->longText('tests_performed')->nullable();
			$table->longText('findings')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
			$table->boolean('archive')->default(0);
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
        Schema::dropIfExists('patients');
    }
}
