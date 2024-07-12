<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugscoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bugscore', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->unsignedBigInteger('project_id'); // Foreign key for the project
            $table->decimal('severity_weight', 5, 2); // Decimal for severity weight (e.g., 0.50)
            $table->decimal('status_weight', 5, 2); // Decimal for status weight (e.g., 0.25)
            $table->decimal('due_weight', 5, 2); // Decimal for due date weight (e.g., 0.25)
            $table->timestamps(); // Created at and updated at timestamps

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bugscore');
    }
}
