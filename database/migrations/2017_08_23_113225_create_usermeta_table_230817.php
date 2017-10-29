<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsermetaTable230817 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('options', function (Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('key', 40)->unique();
            $table->longText('value');

        });

        Schema::create('user_meta', function (Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('meta_key', 40)->index();
            $table->longText('meta_value');
            $table->bigInteger('user_id')->unsigned()->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_meta');
    }
}
