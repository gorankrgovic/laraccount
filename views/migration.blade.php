<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class LaraccountSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create table for storing roles
        Schema::create('{{ $laraccount['tables']['accounts'] }}', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });


        // Create table for associating accounts to users (Many To Many Polymorphic)
        Schema::create('{{ $laraccount['tables']['account_user'] }}', function (Blueprint $table) {
            $table->unsignedInteger('{{ $laraccount['foreign_keys']['account'] }}');
            $table->unsignedInteger('{{ $laraccount['foreign_keys']['user'] }}');
            $table->string('user_type');

            $table->foreign('{{ $laraccount['foreign_keys']['account'] }}')->references('id')->on('{{ $laraccount['tables']['accounts'] }}')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['{{ $laraccount['foreign_keys']['user'] }}', '{{ $laraccount['foreign_keys']['account'] }}', 'user_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{ $laraccount['tables']['account_user'] }}');
        Schema::dropIfExists('{{ $laraccount['tables']['accounts'] }}');
    }
}
