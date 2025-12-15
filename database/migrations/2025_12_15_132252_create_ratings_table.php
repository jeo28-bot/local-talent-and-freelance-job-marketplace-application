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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();

            // Who wrote the review
            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Who is being reviewed
            $table->foreignId('reviewed_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Rating value
            $table->unsignedTinyInteger('rating'); // 1–5

            // Optional message
            $table->text('message')->nullable();

            $table->timestamps();

            // Prevent duplicate reviews
            $table->unique(['reviewer_id', 'reviewed_user_id']);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
