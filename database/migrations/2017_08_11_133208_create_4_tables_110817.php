<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create4Tables110817 extends Migration
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
        
        Schema::create('term_relationships', function (Blueprint $table) 
        {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('term_id')->unsigned()->index();
            $table->bigInteger('post_id')->unsigned()->index();
                  
        });
        
        Schema::create('post_meta', function (Blueprint $table) 
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('meta_key', 40)->index();
            $table->longText('meta_value');
            $table->bigInteger('post_id')->unsigned()->index();
                  
        });
        
        Schema::create('posts', function (Blueprint $table) 
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('post_type', 20);
            $table->bigInteger('post_author')->unsigned()->index();
            $table->datetime('post_date');
            $table->datetime('post_modified');
            $table->string('post_status', 20)->index();
            $table->text('post_name');
            $table->text('post_title');
            $table->text('post_image');
                  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('options');
        Schema::drop('term_relationships');
        Schema::drop('post_meta');
        Schema::drop('posts');
    }
}
