<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_branch',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('address1');
            $table->string('address2');
            $table->string('city',100);
            $table->string('phone',15);
            $table->string('fax',15);
            $table->boolean('status');
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
        Schema::drop('sys_branch');
    }
}
