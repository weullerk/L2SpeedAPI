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
        Schema::create('votetop100arena', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 48)->nullable();
            $table->timestamp('date');
            $table->string('account')->references('login')->on('accounts');
            $table->boolean('claimed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
