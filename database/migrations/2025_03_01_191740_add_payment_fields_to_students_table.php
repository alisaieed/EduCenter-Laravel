<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('students', function (Blueprint $table) {
            $table->decimal('total_course_cost', 10, 2)->default(0)->after('email');
            $table->decimal('amount_paid', 10, 2)->default(0)->after('total_course_cost');
        });
    }

    public function down(): void {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['total_course_cost', 'amount_paid']);
        });
    }
};
