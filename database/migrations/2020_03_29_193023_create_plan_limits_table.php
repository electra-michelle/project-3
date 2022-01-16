<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_limits', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
			$table->decimal('min_amount', 20, 8)->default(0.00000000);
			$table->decimal('max_amount', 20, 8)->default(0.00000000);
			$table->string('currency');
			$table->unique(['plan_id', 'currency']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_limits');
    }
}
