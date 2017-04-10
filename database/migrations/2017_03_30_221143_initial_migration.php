<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitialMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('printers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('departaments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comment');
            $table->boolean('blocked');
            $table->integer('request_id')->unsigned();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned();
            $table->smallInteger('status');
            $table->dateTime('open_date');
            $table->dateTime('due_date')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->boolean('colored');
            $table->boolean('stapled');
            $table->smallInteger('paper_size');
            $table->smallInteger('paper_type');
            $table->string('file');
            $table->integer('printer_id')->unsigned()->nullable();
            $table->dateTime('closed_date')->nullable();
            $table->integer('closed_user_id')->unsigned()->nullable();
            $table->string('refused_reason')->nullable();
            $table->smallInteger('satisfaction_grade')->nullable();
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
        Schema::dropIfExists('requests');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('departaments');
        Schema::dropIfExists('printers');
    }
}
