<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('specialization')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
        });
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
        // Define the relationship with Course
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function down()
    {
        Schema::dropIfExists('instructors');
    }
};
