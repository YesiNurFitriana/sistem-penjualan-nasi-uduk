<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('menus', fn(Blueprint $t) => $t->text('description')->nullable()->after('name'));
        Schema::create('special_orders', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('name', 100); $t->string('whatsapp', 20); $t->date('event_date'); $t->time('pickup_time');
            $t->string('event_type', 60); $t->json('items'); $t->text('notes')->nullable();
            $t->string('status', 30)->default('Menunggu Konfirmasi'); $t->string('admin_note')->nullable(); $t->timestamps();
        });
    }
};
