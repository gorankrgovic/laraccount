<?php
namespace Laraccount\Tests\Migrations;


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaraccountSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('account_user', function (Blueprint $table) {
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('user_id');
            $table->string('user_type');
            $table->foreign('account_id')->references('id')->on('accounts')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['user_id}', 'account_id', 'user_type']);

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('account_user');
        Schema::dropIfExists('accounts');
    }
}
