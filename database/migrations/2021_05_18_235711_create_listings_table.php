<?php

use LaravelFreelancerNL\Aranguent\Facades\Schema;
use LaravelFreelancerNL\Aranguent\Schema\Blueprint;
use LaravelFreelancerNL\Migrations\MigrationCreator;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $collection) {
            $collection->increments('id');
            $collection->string('title');
            $collection->integer('price');
            $collection->string('area');
            $collection->string('address');
            $collection->string('name');
            $collection->string('email');
            $collection->string('phoneNumber');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listings');
    }
}
