<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
			$table->string('company_name')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default('no-image.png');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
			$table->string('qualifications')->nullable();
			$table->string('type')->nullable();
			$table->string('company_url')->nullable();
			$table->string('admin_first_name')->nullable();
			$table->string('admin_last_name')->nullable();
			$table->string('admin_phone')->nullable();
			$table->string('admin_email')->nullable();
			$table->string('certificate')->default('');
            $table->integer('role_id')->default('2');
            $table->string('ip', '16')->nullable();
//            $table->enum('status', ["Active", "Inactive"])->default("Active");
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
