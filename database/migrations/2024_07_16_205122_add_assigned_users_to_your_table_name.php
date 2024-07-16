<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignedUsersToYourTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('forums', function (Blueprint $table) {
            $table->json('assigned_users')->nullable()->after('category');
            // If you prefer storing user IDs as JSON array, use the following line instead:
            // $table->json('assigned_users')->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('your_table_name', function (Blueprint $table) {
            $table->dropColumn('assigned_users');
        });
    }
}
