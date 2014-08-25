<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function($table) {
                $table->increments('id');
                $table->string('phone')->nullable();
                $table->string('full_name')->nullable();
                $table->string('email')->unique();
                $table->decimal('balance',7,2)->default(0);
                $table->string('password');
                $table->string('role');
                $table->string('remember_token',100); //Обязательное поле, для защищенности Cookie
                $table->softDeletes();
                $table->timestamps();

                $table->index('phone');
                $table->index('email');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('users');
	}

}
