<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
