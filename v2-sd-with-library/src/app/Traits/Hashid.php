<?php

namespace App\Traits;

use Vinkla\Hashids\Facades\Hashids;

trait Hashid
{
    public function encodeHash($value)
    {
        dd(Hashids::decode('YBjyXnQrokMRPAl8v3NL'));
        return Hashids::encode($value);
    }

    public function decodeHash($value)
    {
        return Hashids::decode($value);
    }
}
