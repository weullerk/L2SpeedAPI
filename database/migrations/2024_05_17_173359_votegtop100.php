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
        Schema::create('votegtop100', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 48);
            $table->timestamp('date');
            $table->string('account')->nullable()->references('login')->on('accounts');
            $table->boolean('claimed')->default(0);
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
