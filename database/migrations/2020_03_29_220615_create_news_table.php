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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->dateTime('published_from')->nullable();
            $table->timestamps();
        });

		Schema::create('news_translations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('news_id')->constrained()->cascadeOnDelete();
			$table->string('locale')->index();

			$table->string('title');
			$table->text('content');

			$table->unique(['news_id','locale']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_translations');
        Schema::dropIfExists('news');
    }
};
