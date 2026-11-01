<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->string('role', 20)->default('pelanggan')->after('email');
            $t->string('phone', 20)->nullable();
        });
        Schema::create('settings', function (Blueprint $t) { $t->string('key')->primary(); $t->string('value'); });
        Schema::create('daily_quotas', function (Blueprint $t) { $t->date('date')->primary(); $t->unsignedInteger('quota'); });
        Schema::create('menus', function (Blueprint $t) {
            $t->id(); $t->string('name'); $t->unsignedInteger('price'); $t->string('photo')->nullable();
            $t->boolean('is_active')->default(true); $t->boolean('resellable')->default(false);
            $t->text('note')->nullable(); $t->boolean('show_note')->default(false); $t->timestamps();
        });
        Schema::create('batches', function (Blueprint $t) {
            $t->id(); $t->foreignId('menu_id')->constrained(); $t->date('produced_on');
            $t->unsignedInteger('qty'); $t->unsignedInteger('qty_remaining'); $t->unsignedInteger('discarded')->default(0);
            $t->boolean('resale_approved')->default(false); $t->timestamps(); $t->index(['menu_id','produced_on']);
        });
        Schema::create('orders', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained(); $t->date('pickup_date'); $t->time('pickup_time');
            $t->string('status', 30)->default('Menunggu Konfirmasi'); $t->unsignedInteger('total');
            $t->string('reject_reason')->nullable(); $t->timestamp('paid_at')->nullable(); $t->timestamps(); $t->index(['pickup_date','status']);
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id(); $t->foreignId('order_id')->constrained()->cascadeOnDelete(); $t->foreignId('menu_id')->constrained();
            $t->unsignedInteger('qty'); $t->unsignedInteger('price');
        });
        Schema::create('sales', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained(); $t->unsignedInteger('total');
            $t->unsignedInteger('paid'); $t->unsignedInteger('change'); $t->timestamps();
        });
        Schema::create('sale_items', function (Blueprint $t) {
            $t->id(); $t->foreignId('sale_id')->constrained()->cascadeOnDelete(); $t->foreignId('menu_id')->constrained();
            $t->unsignedInteger('qty'); $t->unsignedInteger('price'); $t->json('allocations')->nullable();
        });
    }
};
