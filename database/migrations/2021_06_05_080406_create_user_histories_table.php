<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('action', [
                'registration',
                'withdraw_complete',
                'withdraw_request',
                'commission_earned',
                'daily_income',
                'new_referral',
                'plan_finished',
                'new_investment',
                'settings_updated',
                'principals_returned',
            ]);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('data')->nullable();
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
        Schema::dropIfExists('user_histories');
    }
}
