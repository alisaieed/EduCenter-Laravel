<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->date('dob')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }
    public function certificates()
    {
        return $this->belongsToMany(Certificate::class);
    }
    public function down()
    {
        Schema::dropIfExists('students');
    }
};

