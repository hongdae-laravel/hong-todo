<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagGroupsTable extends Migration
{
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('tagging_tag_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->index();
            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagging_tag_groups');
    }
}
