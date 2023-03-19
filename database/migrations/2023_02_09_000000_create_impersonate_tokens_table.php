<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImpersonateTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::connection(config('impersonate.connection'))->create(config('impersonate.table.name'), function (Blueprint $table) {
            $table->{config('impersonate.table.identifier.type')}('admin', ...\Illuminate\Support\Arr::wrap(config('impersonate.table.identifier.options')));
            $table->{config('impersonate.table.identifier.type')}('user', ...\Illuminate\Support\Arr::wrap(config('impersonate.table.identifier.options')));
            $table->string('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::connection(config('impersonate.connection'))->dropIfExists(config('impersonate.table.name'));
    }
}
