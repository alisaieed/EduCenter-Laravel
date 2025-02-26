<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->date('start_date');  // Added start_date field
            $table->date('end_date');    // Added end_date field
            $table->timestamps();
            $table->string('certificate_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }
    
    public function instructors()
    {
        return $this->belongsToMany(Instructor::class);
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
