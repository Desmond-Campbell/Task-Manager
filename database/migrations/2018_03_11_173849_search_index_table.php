<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SearchIndexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_index', function (Blueprint $table) {
            $table->increments('id');
            $table->engine = 'MyISAM'; // means you can't use foreign key constraints
            $table->integer('project_id');
            $table->integer('task_id');
            $table->text('data');
            $table->text('keywords');
            $table->boolean('indexed')->default(0)->nullable();
            $table->integer('user_id');
            $table->timestamps();
        });

        DB::statement('ALTER TABLE search_index ADD FULLTEXT search(keywords)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('search_index', function($table) {
            $table->dropIndex('search');
        });

        Schema::dropIfExists('search_index');
    }
}
