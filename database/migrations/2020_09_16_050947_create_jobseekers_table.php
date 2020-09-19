<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobseekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobseekers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('job_title');
            $table->string('email');
            $table->string('location');
            $table->string('description');
            $table->string('profile_photo');
            $table->integer('phone_number');
            $table->boolean('status');
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
        Schema::dropIfExists('jobseekers');
    }
}
