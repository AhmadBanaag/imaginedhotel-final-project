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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained('user_roles', 'role_id')->after('id'); // values: 'admin', 'account_user', 'guest'
            $table->string('first_name')->nullable()->after('role_id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('email'); //email is the default login method in the usars table
            $table->boolean('is_active')->default(true)->after('password'); // handles the activate or deactibate account 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'first_name', 'last_name', 'phone', 'is_active']);
        });
    }
};
