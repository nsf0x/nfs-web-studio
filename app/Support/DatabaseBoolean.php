<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DatabaseBoolean
{
    public static function fromRequest(Request $request, string $key): bool|string
    {
        $value = $request->boolean($key);

        return self::forDriver($value, DB::connection()->getDriverName());
    }

    public static function forDriver(bool $value, string $driver): bool|string
    {
        if ($driver === 'pgsql') {
            return $value ? 'true' : 'false';
        }

        return $value;
    }
}
