<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta', function (Blueprint $table) {
            $table->id();
            $table->string('type')->index();
            $table->unsignedBigInteger('parent')->default(null)->index();
            $table->char('published',1)->default(null)->index();
            $table->foreignId('author_id')->constrained('users')->onUpdate('no action')->onDelete('restrict');
            $table->unsignedBigInteger('position')->default(null)->index();
            $table->string('taxonomy')->default(null)->index();
            $table->unsignedTinyInteger('level')->default(1)->index();
            $table->text('title')->nullable(true);
            $table->text('title_nav')->nullable(true);
            $table->text('title_meta')->nullable(true);
            $table->text('abstract')->nullable(true);
            $table->text('abstract_meta')->nullable(true);
            $table->text('url')->nullable(true);
            $table->string('access_key')->nullable(true);
            $table->string('template')->nullable(true);
            $table->json('configs')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta');
    }
};
