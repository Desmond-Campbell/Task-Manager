<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('priority', 10, 1)->nullable()->default(50.0);
            $table->integer('completion')->nullable()->default(0);
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->text('assignees')->nullable();
            $table->text('customers')->nullable();
            $table->text('categories')->nullable();
            $table->text('features')->nullable();
            $table->string('status')->nullable()->default('queued');
            $table->boolean('completed')->nullable()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('project_id')->references('id')->on('projects');
        });

        Schema::create('task_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('priority', 10, 1)->nullable()->default(50.0);
            $table->boolean('completed')->nullable()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('task_followups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->unsigned();
            $table->string('action');
            $table->date('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->boolean('completed')->nullable()->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('task_id')->references('id')->on('tasks');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('object_id')->unsigned();
            $table->string('object_type');
            $table->string('description');
            $table->text('old_data')->nullable();
            $table->text('new_data')->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('name');
            $table->integer('member_user_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('member_user_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('features');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('members');
        Schema::dropIfExists('activities');
        Schema::dropIfExists('task_followups');
        Schema::dropIfExists('task_items');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('project');
    }
}
