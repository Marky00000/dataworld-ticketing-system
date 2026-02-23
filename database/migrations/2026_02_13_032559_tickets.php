<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->string('subject');
            
            // Define columns - NO 'after' CLAUSES ANYWHERE
            $table->unsignedBigInteger('category_id');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->text('description');
            $table->json('attachments')->nullable();
            $table->enum('status', ['pending', 'open', 'in_progress', 'resolved', 'closed'])->default('pending');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            
            // Contact information columns
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_company')->nullable();
            
            // NEW COLUMNS - Device Information
            $table->string('model')->nullable()->comment('Device model (e.g., RT-AC68U, DSL-3782)');
            $table->string('firmware_version')->nullable()->comment('Firmware version of the device');
            $table->string('serial_number')->nullable()->comment('Device serial number');
            
            $table->timestamps();
            $table->timestamp('resolved_at')->nullable();
            
            // Foreign keys
            $table->foreign('category_id')->references('id')->on('ticket_categories');
            $table->foreign('assigned_to')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            
            // Optional: Add indexes for better query performance
            $table->index('model');
            $table->index('serial_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};