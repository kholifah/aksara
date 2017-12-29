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
            $table->longText('post_content');
            $table->bigInteger('post_author')->unsigned()->index();
            $table->datetime('post_date');
            $table->datetime('post_modified');
            $table->string('post_status', 20)->index();
            $table->text('post_title');
            $table->text('post_image');
            $table->text('post_slug');

        });

        Schema::create('taxonomies', function (Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
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

        Schema::create('term_relationships', function (Blueprint $table)
        {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('term_id')->unsigned();
            $table->foreign('term_id')
                    ->references('id')
                    ->on('term_id')
                    ->onDelete('cascade');
            $table->bigInteger('post_id')->unsigned()->index();
            $table->bigInteger('post_id')->unsigned();
            $table->foreign('post_id')
                    ->references('id')
                    ->on('post_id')
                    ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_relationships');
        Schema::dropIfExists('taxonomies');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('post_meta');
        Schema::dropIfExists('posts');
    }

}
