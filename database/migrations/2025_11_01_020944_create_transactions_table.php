<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Foreign references
            $table->foreignId('job_id')->nullable()->constrained('job_posts')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Display info
            $table->string('job_title'); // "Graphic Design"
            $table->decimal('amount', 10, 2); // "5000.00"
            $table->enum('status', ['pending', 'paid', 'requested', 'completed'])->default('pending');
            $table->string('payment_method')->nullable(); // GCash / PayPal
            $table->string('reference_no')->nullable(); // optional (for GCash/PayPal ref)
            $table->dateTime('payment_date')->nullable();

            // Auto timestamps
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
