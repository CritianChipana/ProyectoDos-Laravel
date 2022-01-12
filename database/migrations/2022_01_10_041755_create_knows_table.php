<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knows', function (Blueprint $table) {
            $table->id();
            $table->string("knowName",50);
            $table->string("knowArea",50);
            $table->string("typeOfFile",7);
            $table->string("knowArchive",80);
            $table->unsignedBigInteger('user_Id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->boolean("state")->default(true);
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
        Schema::dropIfExists('knows');
    }
}