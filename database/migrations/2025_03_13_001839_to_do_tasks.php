<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('to_do_tasks', function (Blueprint $table) {
//            $table->id();
            $table->uuid('uuid')->primary();
            $table->string('task');
            $table->boolean('completed')->default(false)->index();
            $table->timestamps();
//            $table->softDeletes();

            $table->integer('to_do_list_id')->unsigned()->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('to_do_tasks');
    }
};
