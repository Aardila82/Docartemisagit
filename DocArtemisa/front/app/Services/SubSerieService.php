<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class SubSerieService extends ApiService
{
    protected string $urlBase;

    public function __construct()
    {
        $this->urlBase = "http://127.0.0.1:8000/api/";
    }

    public function getAll()
    {
        try {
            $response = $this->get('subSerieAPI');
            return $this->successResponse($response->object());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function getSerieById(int $id)
    {
        try {
            $response = $this->get('subSerieAPI/' . $id);
            return $this->successResponse($response->object());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function createSerie(array $data)
    {
        try {
            $response = $this->post('subSerieAPI', $data);
            $body = $response->object();
            $statusCode = $body->status ?? 200;
            $mensaje = $body->mensaje ?? 'Sub Serie creada correctamente.';

            return $this->successResponse($mensaje, $statusCode);
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function cargarMasivaSeries(string $filePath)
    {
        try {
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'error' => "Archivo no encontrado en la ruta proporcionada: $filePath",
                    'status' => 400
                ], 400);
            }

            $response = Http::withOptions([
                'timeout' => 30,
                'max_redirects' => 10,
            ])
                ->attach(
                    'csv_file',
                    file_get_contents($filePath),
                    basename($filePath)
                )
                ->post($this->urlBase . 'subSerieMasivaAPI');

            return $this->successResponse($response->object(), $response->status());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function updateSerie(int $id, array $data)
    {
        try {
            $response = $this->put("subSerieAPI/{$id}", $data);
            $body = $response->object();
            return [
                'mensaje' => $body->mensaje ?? 'Actualizado',
                'status' => $response->status()
            ];
        } catch (RequestException $e) {
            return [
                'mensaje' => 'Error al actualizar la serie',
                'status' => 500
            ];
        }
    }

    public function deleteSerie(int $id)
    {
        try {
            $response = $this->delete("subSerieAPI/{$id}");
            $body = $response->object();
            $statusCode = $response->status();

            return $this->successResponse($body, $statusCode);
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function getEstados()
    {
        try {
            $response = $this->get('estadoAPI');
            return $response->json(); // Retorna los datos sin detener ejecución
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }
}
