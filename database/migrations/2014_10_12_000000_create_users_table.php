<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            // $table->rememberToken();
            // $table->timestamps();
            $table->id();
            $table->string('firstName',50);
            $table->string('lastName',50);
            $table->string('password');
            $table->string('email')->unique();
            $table->string('workSpace',50)->nullable();
            $table->string('mobileNo',50)->nullable();
            $table->string('companyName',100)->nullable();
            $table->string('indutryName',100)->nullable();
            $table->string('position',100)->nullable();
            $table->boolean('isActive');
            $table->boolean('isAdmi');
            $table->boolean('isMasterAdmi');
            $table->boolean('state')->default(true);
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
        Schema::dropIfExists('users');
    }
}
