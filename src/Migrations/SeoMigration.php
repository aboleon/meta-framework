<?php

namespace Aboleon\MetaFramework\Migrations;

use Illuminate\Database\Schema\Blueprint;

class SeoMigration
{
    public static function columns(Blueprint $table)
    {
        $table->longText('meta_title')->nullable();
        $table->longText('meta_description')->nullable();
    }
}