<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('payer');
            $table->unsignedBigInteger('payee');

            $table->decimal('value', 10, 2);

            $table->enum('status', ['in process', 'processed', 'canceled', 'unprocessed', 'not authorized'])->default('in process');

            $table->foreign('payer')
            ->references('id')
            ->on('users');

            $table->foreign('payee')
            ->references('id')
            ->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
