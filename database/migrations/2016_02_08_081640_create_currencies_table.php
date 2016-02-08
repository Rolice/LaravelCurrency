<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::setConnection(DB::connection(Config::get('laravel-currency.laravel-currency.connection')))->create('currencies', function (Blueprint $table) {
            $table->char('code', 3);
            $table->char('base', 3)->index('idx_base');
            $table->unsignedInteger('price');
            $table->dateTime('refreshed_at')->index('idx_refreshed_at');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::setConnection(DB::connection(Config::get('laravel-currency.laravel-currency.connection')))->dropIfExists('currencies');
    }
}
