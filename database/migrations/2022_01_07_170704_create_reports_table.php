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
            $table->string("reportTitle");
            $table->text("reportDescription");
            $table->text("reportId");
            $table->text("groupId");
            $table->boolean("isActive");
            $table->string("sectionId");
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
        Schema::dropIfExists('reports');
    }
}
