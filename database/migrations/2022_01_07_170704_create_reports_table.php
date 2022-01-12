<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            // $table->id();
            // $table->string("nombre");
            // $table->timestamps();
            $table->id();
            $table->string("billing",80)->nullable();
            $table->string("presale",80)->nullable();
            $table->string("rawMaterial",80)->nullable();
            $table->string("humanResources",80)->nullable();
            $table->string("oee",80)->nullable();
            $table->string("firecCost",80)->nullable();
            $table->string("adminWorkSheet",80)->nullable();
            $table->string("maintenance",80)->nullable();
            $table->string("ouBoundLogistics",80)->nullable();
            $table->string("marketing",80)->nullable();
            $table->string("rentals",80)->nullable();
            $table->string("services",80)->nullable();
            
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('reports');
    }
}
