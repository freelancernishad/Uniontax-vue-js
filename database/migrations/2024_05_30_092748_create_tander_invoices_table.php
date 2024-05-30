<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTanderInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tander_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tanderid');
            $table->decimal('amount', 15, 2);
            $table->string('khat');
            $table->string('orthobochor');
            $table->string('status');
            $table->date('date');
            $table->year('year');
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
        Schema::dropIfExists('tander_invoices');
    }
}
