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
            // Profile Information
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->text('bio')->nullable()->after('phone');
            $table->string('profile_image')->nullable()->after('bio');
            $table->date('date_of_birth')->nullable()->after('profile_image');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            
            // Academic Information
            $table->string('institution')->nullable()->after('gender');
            $table->string('class')->nullable()->after('institution');
            $table->string('district')->nullable()->after('class');
            $table->string('division')->nullable()->after('district');
            $table->year('hsc_year')->nullable()->after('division');
            
            // Gamification & Progress
            $table->integer('level')->default(1)->after('hsc_year');
            $table->integer('total_points')->default(0)->after('level');
            $table->integer('current_streak')->default(0)->after('total_points');
            $table->integer('longest_streak')->default(0)->after('current_streak');
            $table->timestamp('last_activity_at')->nullable()->after('longest_streak');
            
            // Preferences & Settings
            $table->json('preferences')->nullable()->after('last_activity_at'); // Theme, notifications, etc.
            $table->boolean('email_notifications')->default(true)->after('preferences');
            $table->string('timezone')->default('Asia/Dhaka')->after('email_notifications');
            $table->string('language')->default('bn')->after('timezone');
            
            // Status Fields
            $table->boolean('is_verified')->default(false)->after('language');
            $table->boolean('is_active')->default(true)->after('is_verified');
            $table->timestamp('email_verified_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username', 'phone', 'bio', 'profile_image', 'date_of_birth', 'gender',
                'institution', 'class', 'district', 'division', 'hsc_year',
                'level', 'total_points', 'current_streak', 'longest_streak', 'last_activity_at',
                'preferences', 'email_notifications', 'timezone', 'language',
                'is_verified', 'is_active'
            ]);
        });
    }
};
