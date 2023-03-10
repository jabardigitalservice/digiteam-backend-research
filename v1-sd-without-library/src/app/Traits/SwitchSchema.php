<?php

namespace App\Traits;

trait SwitchSchema
{
    /**
     * Boot function from Laravel.
     */
    public function getTable()
    {
        return config('database.connections.pgsql.search_path') . '.' . parent::getTable();
    }
}
