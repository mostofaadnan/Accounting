<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_infos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('account_type');
            $table->text('account_name')->nullable();
            $table->text('account_number')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('bank_phone')->nullable();
            $table->text('bank_address')->nullable();
            $table->float('opening_balance',8, 2)->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('account_infos');
    }
}
