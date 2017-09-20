<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyNTermTable081017 extends Migration 
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('taxonomies', function (Blueprint $table) 
        {
            $table->bigIncrements('id')->unsigned();
            $table->string('post_type', 20);
            $table->string('taxonomy_name', 40);
            $table->text('slug');            
        });
        
        Schema::create('terms', function (Blueprint $table) 
        {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('taxonomy_id')->index();
            $table->text('name');
            $table->text('slug');
            $table->bigInteger('parent')->unsigned();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() 
    {
        Schema::drop('taxonomies');
        Schema::drop('terms');
    }

}
