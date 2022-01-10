<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();
            $table->string("billing",80);
            $table->string("presale",80);
            $table->string("rawMaterial",80);
            $table->string("humanResources",80);
            $table->string("oee",80);
            $table->string("firecCost",80);
            $table->string("adminWorkSheet",80);
            $table->string("maintenance",80);
            $table->string("ouBoundLogistics",80);
            $table->string("marketing",80);
            $table->string("rentals",80);
            $table->string("services",80);

            $table->unsignedBigInteger('userId')->nullable();
            $table->foreign('userId')->references('id')->on('users')->onDelete('set null');
            $table->boolean("state");
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
        Schema::dropIfExists('information');
    }
}
