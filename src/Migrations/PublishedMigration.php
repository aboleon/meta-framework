<?php

namespace Aboleon\MetaFramework\Migrations;

use Illuminate\Database\Schema\Blueprint;

class PublishedMigration
{
    public static function columns(Blueprint $table)
    {
        $table->boolean('published')->default(false)->index();
    }
}