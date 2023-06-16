<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenderListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tender_lists', function (Blueprint $table) {
            $table->id();
            $table->string('union_name')->nullable();
            $table->string('tender_id')->nullable();
            $table->string('tender_type')->nullable();
            $table->string('tender_name')->nullable();
            $table->longText('description')->nullable();
            $table->string('tender_word_no')->nullable();
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('union')->nullable();
            $table->string('govt_price')->nullable();
            $table->string('form_price')->nullable();
            $table->string('deposit_percent')->nullable();
            $table->string('form_buy_last_date')->nullable();
            $table->string('tender_start')->nullable();
            $table->string('tender_end')->nullable();
            $table->string('tender_open')->nullable();
            $table->longText('tender_roles')->nullable();
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
        Schema::dropIfExists('tender_lists');
    }
}
