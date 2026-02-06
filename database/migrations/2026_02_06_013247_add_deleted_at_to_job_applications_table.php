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
        Schema::table('job_applications', function ($table) {
            $table->softDeletes(); // adds deleted_at column
        });
    }

    public function down()
    {
        Schema::table('job_applications', function ($table) {
            $table->dropColumn('deleted_at');
        });
    }

};
