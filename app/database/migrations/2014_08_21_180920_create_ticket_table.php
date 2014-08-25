<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('tickets',function($table){
                $table->increments('id');
                $table->integer('user_id');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('url',255)->nullable();
                $table->string('file_path',250)->nullable();
                $table->integer('priority_id')->nullable();
                $table->decimal('price')->nullable();
                $table->integer('bt_user_id')->nullable();
                $table->boolean('apply')->default(false);
                $table->boolean('close')->default(false);
                $table->dateTime('close_dt')->nullable();
                $table->softDeletes();
                $table->timestamps();

                /*$table->foreign('user_id')
                    ->references('id')->on('users');
                $table->foreign('priority_id')
                    ->references('id')->on('priorities');*/

                $table->index('user_id');
                $table->index('title');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tickets');
	}

}
