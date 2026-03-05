<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('user_type', ['admin', 'tech', 'user'])->default('user');
            $table->string('company')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->rememberToken();

            // Remove the after() methods - they're causing the syntax error
            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_expires')->nullable();

            $table->timestamps();
        });

        // Create default admin account
        $this->createDefaultAdmin();
    }
    
    /**
     * Create default admin account
     */
    private function createDefaultAdmin(): void
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@dataworld.com',
            'email_verified_at' => now(),
            'password' => Hash::make('P455w0rd!!'),
            'user_type' => 'admin',
            'company' => 'Dataworld',
            'phone' => '+1 (555) 123-4567',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};