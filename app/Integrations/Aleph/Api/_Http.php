<?php

namespace App\Integrations\Aleph\Api;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class _Http
{
    public static function boot(): void
    {
        Http::macro('Aleph', function (): PendingRequest {
            $baseUrl = config('aleph.baseUrl');

            return Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->baseUrl($baseUrl);
        });
    }
}
