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

public function findById($id): array
{
    try {
        $response = Http::get($this->urlBase . "tipodocumental/{$id}");

        if ($response->successful()) {
            return $response->json(); // Devuelve el registro
        }

        return ['error' => 'Error al obtener el tipo documental'];
    } catch (\Exception $e) {
        return ['error' => 'Excepción al obtener tipo documental: ' . $e->getMessage()];
    }
}

public function update($id, array $data)
{
    try {
        $response = Http::put($this->urlBase . 'tipodocumental/' . $id, $data);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    } catch (\Exception $e) {
        return null;
    }
}

public function cambiarEstado($id)
{
    try {
        $response = Http::delete($this->urlBase . 'tipodocumental/' . $id);

        return $response->json();
    } catch (\Exception $e) {
        return ['error' => 'Error al cambiar el estado: ' . $e->getMessage()];
    }
}






}
