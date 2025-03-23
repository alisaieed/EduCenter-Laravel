<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('head_instructor_id')->nullable();
            $table->timestamps();

            $table->foreign('head_instructor_id')->references('id')->on('instructors')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
