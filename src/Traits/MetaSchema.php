<?php

namespace Aboleon\MetaFramework\Traits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait MetaSchema
{
    protected function hasForeignKey(Blueprint $table, string $foreignKeyName): bool
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $foreignKeys = $sm->listTableForeignKeys($table->getTable());

        foreach ($foreignKeys as $foreignKey) {
            if (in_array($foreignKeyName, (array) $foreignKey->getName())) {
                return true;
            }
        }

        return false;
    }

    protected function hasIndex(Blueprint $table, string $index): bool
    {
        $sm = Schema::getConnection()->getDoctrineSchemaManager();
        $indexes = $sm->listTableIndexes($table->getTable());

        foreach ($indexes as $indexKey) {
            if (in_array($index, (array) $indexKey->getName())) {
                return true;
            }
        }

        return false;
    }
}