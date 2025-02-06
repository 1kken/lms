<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->string('student_id'); // Instead of foreignId
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');

            $table->string('rfid'); // Instead of book_id
            $table->foreign('rfid')->references('rfid')->on('books')->onDelete('cascade');

            $table->timestamp('issue_date');
            $table->timestamp('return_date')->nullable();
            $table->string('issue_status')->nullable();
            $table->timestamp('return_day')->nullable();
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
        Schema::dropIfExists('book_issues');
    }
}
