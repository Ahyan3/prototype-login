<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'first_name')) {
            $table->string('first_name');
        }
        if (!Schema::hasColumn('users', 'last_name')) {
            $table->string('last_name');
        }
        if (!Schema::hasColumn('users', 'student_id')) {
            $table->string('student_id');
        }
    });
}

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'first_name',
                'last_name',
                'student_id'
            ]);

        });
    }
};
