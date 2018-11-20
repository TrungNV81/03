<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCsvDataImportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_data_import', function (Blueprint $table) {
            $table->integer('id');
            $table->string('sub_id', 50);
            $table->string('A', 255)->nullable();
            $table->string('B', 255)->nullable();
            $table->string('C', 255)->nullable();
            $table->string('D', 255)->nullable();
            $table->string('E', 255)->nullable();
            $table->string('F', 255)->nullable();
            $table->string('G')->nullable();
            $table->string('H')->nullable();
            $table->string('I', 255)->nullable();
            $table->string('J')->nullable();
            $table->string('K', 255)->nullable();
            $table->string('L')->nullable();
            $table->string('M')->nullable();
            $table->string('N')->nullable();
            $table->string('O', 255)->nullable();
            $table->string('P', 255)->nullable();
            $table->string('Q', 255)->nullable();
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
        Schema::drop('csv_data_import');
    }
}