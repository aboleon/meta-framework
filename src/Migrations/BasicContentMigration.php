<?php

namespace Aboleon\MetaFramework\Migrations;

use Illuminate\Database\Schema\Blueprint;

class BasicContentMigration
{
    public static function columns(Blueprint $table)
    {
        $table->longText('title')->nullable();
        $table->longText('content')->nullable();
    }
}