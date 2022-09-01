<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('payment_type');
            $table->tinyInteger('operation_type');
            $table->text('transection_no');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('invoice_id');
            $table->text('date');
            $table->text('description');
            $table->tinyInteger('payment_method');
            $table->float('amount' ,8, 2);
            $table->text('payment_descripiton')->nullable();
            $table->tinyInteger('status');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('accounts');
    }
}
