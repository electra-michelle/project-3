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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
			$table->foreignId('plan_id')->constrained()->cascadeOnDelete();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->foreignId('payment_system_id')->constrained()->cascadeOnDelete();
			$table->decimal('amount', 15, 8)->default(0.00000000);
			$table->unsignedInteger('period_passed')->default(0);
			$table->unsignedInteger('confirmations')->default(0);
			$table->enum('status', ['pending', 'frozen', 'cancelled', 'active', 'finished'])->default('pending');
			$table->string('deposit_address')->nullable();
			$table->enum('payment_type', ['invest', 'reinvest'])->default('invest');
			$table->string('transaction_id')->nullable();
			$table->timestamp('confirmed_at')->nullable();
			$table->timestamp('last_credited_at')->nullable();
            $table->timestamps();
			$table->text('comment')->nullable();
			$table->string('url')->unique();

        });


		DB::statement("ALTER TABLE deposits AUTO_INCREMENT = 8502;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};
