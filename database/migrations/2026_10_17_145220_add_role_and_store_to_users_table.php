<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Директора и менеджеров теперь определяет users.role + users.store_id
        Schema::table('stores', function (Blueprint $table) {
            $table->dropConstrainedForeignId('director_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('customer')->after('password');
            // Магазин сотрудника. У админа и покупателей пусто.
            $table->foreignId('store_id')->nullable()->after('role')
                ->constrained('stores')->nullOnDelete();
            $table->index('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('store_id');
            $table->dropIndex(['role']);
            $table->dropColumn('role');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->foreignId('director_id')->nullable()->after('address')
                ->constrained('users')->nullOnDelete();
        });
    }
};
