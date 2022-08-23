<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $t){
            $t->unsignedBigInteger('empresa_id');
            $t->foreign('empresa_id')->on('empresas')->references('id');
            $t->string('mime_type_foto',100)->nullable();
        });
        DB::statement('ALTER TABLE users ADD arquivo_foto MEDIUMBLOB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function(Blueprint $t){
            $t->dropConstrainedForeignId('empresa_id');
            $t->dropColumn('empresa_id');
        });
    }
}
