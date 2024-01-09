<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBurndownchartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('burndownchart', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for each task in the burndown chart
            $table->string('task_name'); // Name or title of the task
            $table->text('description')->nullable(); // Description of the task
            $table->unsignedSmallInteger('story_points')->default(0); // Estimated story points for the task
            $table->date('due_date')->nullable(); // Due date for the task
            $table->enum('status', ['Not Started', 'In Progress', 'Completed'])->default('Not Started');
            $table->string('user_name');
            $table->unsignedBigInteger('task_id'); // Foreign key relation with tasks table
            $table->unsignedInteger('proj_id'); 

            // Define foreign key constraints.
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            // relationship with the 'tasks' table. If a task is update, its associated burndown chart entry will also be update.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('burndownchart');
    }
}
