<?php

namespace App\Models\Traits;

trait StaticHelpers
{
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
