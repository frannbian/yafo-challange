<?php

namespace App\Integrations\Aleph;

use App\Integrations\Aleph\Api\_Http;

class AlephProvider
{
    public static function boot(): void
    {
        _Http::boot();
    }

    public function __construct()
    {
        _Http::boot();
    }
}
