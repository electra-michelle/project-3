<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_systems', function (Blueprint $table) {
            $table->id();
			$table->string('name');
			$table->string('value')->unique();
			$table->integer('decimals')->default(2);
			$table->string('currency')->default('USD');
			$table->boolean('is_active')->default(false);
			$table->boolean('payouts_enabled')->default(false);
			$table->decimal('withdraw_minimum', 15, 8)->default(0.00000000);
			$table->string('last_visited_block')->nullable();
			$table->timestamp('last_large_cron')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_systems');
    }
};
