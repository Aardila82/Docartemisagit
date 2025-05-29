<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class TipoDocumentalService
{
    protected string $urlBase;

    public function __construct()
    {
        $this->urlBase = "http://127.0.0.1:8000/api/";
    }

    public function getAll(): array
{
    try {
        $response = Http::get($this->urlBase . 'tipodocumental');

        if ($response->successful()) {
            return $response->json() ?? [];
        }

        return [];
    } catch (RequestException $e) {
        return [];
    }
}

public function create(array $data): array
{
    try {
        $response = Http::post($this->urlBase . 'tipodocumental', $data);

        if ($response->successful()) {
            return $response->json(); // Retorna la respuesta del servidor
        }

        // Si falla, retornamos error con mensaje del servidor
        return ['error' => 'Error al crear el tipo documental: ' . $response->body()];
    } catch (\Exception $e) {
        // Captura cualquier excepción (como que no haya conexión)
        return ['error' => 'Excepción al crear tipo documental: ' . $e->getMessage()];
    }
}





}
