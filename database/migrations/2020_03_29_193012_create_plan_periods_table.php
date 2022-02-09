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
        Schema::create('plan_periods', function (Blueprint $table) {
            $table->id();
			$table->foreignId('plan_id')->constrained()->cascadeOnDelete();
			$table->decimal('interest', 8, 2);
			$table->integer('period_start');
			$table->integer('period_end');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_periods');
    }
};
