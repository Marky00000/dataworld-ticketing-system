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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ticket_id');
            $table->unsignedBigInteger('user_id'); // Who sent the message (from users table)
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->enum('message_type', [
                'comment', 
                'status_change', 
                'assignment_change', 
                'priority_change', 
                'system_note'
            ])->default('comment');
            $table->boolean('is_internal_note')->default(false)->comment('Internal notes visible only to staff');
            $table->json('metadata')->nullable()->comment('Stores previous values for changes');
            $table->timestamps();
            $table->softDeletes(); // Allow soft deletion of messages
            
            // Foreign keys
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index('ticket_id');
            $table->index('user_id');
            $table->index('message_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};