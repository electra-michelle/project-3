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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
			$table->foreignId('user_id')->constrained()->cascadeOnDelete();
			$table->foreignId('payment_system_id')->constrained()->cascadeOnDelete();
			$table->string('transaction_id')->nullable();
			$table->decimal('amount', 15, 8)->default(0.00000000);
			$table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
			$table->timestamp('paid_at')->nullable();
            $table->timestamps();
			$table->text('comment')->nullable();
        });

		DB::statement("ALTER TABLE payouts AUTO_INCREMENT = 8502;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payouts');
    }
};
