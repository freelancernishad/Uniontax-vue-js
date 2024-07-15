<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVillageCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village_courts', function (Blueprint $table) {
            $table->id();
            $table->string('district');
            $table->string('upazila');
            $table->string('mouza');
            $table->string('subject');
            $table->text('medium');
            $table->string('rs_bs');
            $table->string('khatian_no');
            $table->string('dag_no');
            $table->string('land_amount');
            $table->string('amount_type');
            $table->string('total_khatian_land');
            $table->string('total_land_amount');
            $table->string('total_land_in_words');
            $table->string('applicant_name');
            $table->string('applicant_father_husband_name');
            $table->string('applicant_address');
            $table->string('applicant_mobile');
            $table->string('applicant_email')->nullable();
            $table->string('applicant_nid_no');
            $table->string('applicant_photo');
            $table->string('applicant_signature');
            $table->string('representative_name')->nullable();
            $table->string('representative_father_husband_name')->nullable();
            $table->string('representative_address')->nullable();
            $table->string('representative_mobile')->nullable();
            $table->string('representative_email')->nullable();
            $table->string('representative_age')->nullable();
            $table->string('representative_relationship')->nullable();
            $table->string('representative_photo')->nullable();
            $table->string('representative_signature')->nullable();
            $table->string('document')->nullable();
            $table->string('miscaseType');
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
        Schema::dropIfExists('village_courts');
    }
}
