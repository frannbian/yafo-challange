<?php

namespace App\Integrations\Aleph\Api;

use App\Dtos\CategoryDto;
use App\Dtos\CMDBDto;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Aleph
{
    /**
     * Get currencies rate from the currency broker
     *
     *
     * @throws ConnectionException
     * @throws Exception
     */
    public function getCategories(): Collection
    {
        $response = Http::Aleph()
            ->asForm()
            ->post('/get_categorias', ['api_key' => config('aleph.apiKey')]);

        if (! $response->ok()) {
            //TODO: send notifications to a channel like slack or email advicing API does not working.
            Log::error(message: json_encode(['error' => 'There was an error obtaining categories', 'response' => $response->json()]));
        }

        return $response
            ->collect('categorias')
            ->map(fn (array $category) => new CategoryDto(
                id: $category['id'],
                name: $category['nombre'],
                cmdb_fields: $category['campos_cmdb'],
            ))
            ->sortBy(['id', 'ASC']);
    }

    /**
     * Get currencies rate from the currency broker
     *
     *
     * @throws ConnectionException
     * @throws Exception
     */
    public function getCMDB(Int $categoryId = null): Collection
    {
        $response = Http::Aleph()
            ->asForm()
            ->post('/get_cmdb', ['api_key' => config('aleph.apiKey'), 'categoria_id' => $categoryId]);

        if (! $response->ok()) {
            //TODO: send notifications to a channel like slack or email advicing API does not working.
            Log::error(message: json_encode(['error' => 'There was an error obtaining cmdb', 'response' => $response->json()]));
        }

        return $response
            ->collect('cmdb')
            ->map(fn (array $cmdb) => new CMDBDto(
                identificator: $cmdb['identificador'],
                name: $cmdb['nombre'],
                category_id: $cmdb['categoria_id'],
                subcategory: $cmdb['subcategoria'] ?? null,
            ))
            ->sortBy(['identificador', 'ASC']);
    }

}
