<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsDataImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_data_import', function (Blueprint $table) {
            $table->integer('id');
            $table->string('sub_id', 50);
            $table->string('sheet', 255)->nullable();
            $table->string('floor', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('thickness', 255)->nullable();
            $table->integer('total');
            $table->primary(['id', 'sub_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('details_data_import');
    }
}
