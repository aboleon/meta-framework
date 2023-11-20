<?php

namespace MetaFramework\Traits;

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
}