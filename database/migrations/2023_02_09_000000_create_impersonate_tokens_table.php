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
        Schema::create('impersonate_token', function (Blueprint $table) {
            $table->{config('impersonate.table_identifier_type', 'unsignedBigInteger')}('admin', ...\Illuminate\Support\Arr::wrap(config('impersonate.table_identifier_options', [])));
            $table->{config('impersonate.table_identifier_type', 'unsignedBigInteger')}('user', ...\Illuminate\Support\Arr::wrap(config('impersonate.table_identifier_options', [])));
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
        Schema::dropIfExists('impersonate_token');
    }
}
