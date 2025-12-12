<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('history_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_type')->nullable();     // admin, client, employee
            $table->text('details');                     // log message
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('history_logs');
    }

};
