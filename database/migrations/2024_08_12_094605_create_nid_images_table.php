<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNidImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nid_images', function (Blueprint $table) {
            $table->id();
            $table->string('name_bengali')->nullable();
            $table->string('name_english')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('nid_no')->nullable();
            $table->string('village_road')->nullable();
            $table->string('post_office')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('postcode')->nullable();
            $table->string('thana')->nullable();
            $table->string('district')->nullable();
            $table->string('front_attachment')->nullable();
            $table->string('back_attachment')->nullable();
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
        Schema::dropIfExists('nid_images');
    }
}
