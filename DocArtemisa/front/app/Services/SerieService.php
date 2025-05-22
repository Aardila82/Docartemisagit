<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;

class SerieService extends ApiService
{
    protected string $urlBase;

    function __construct()
    {
        $this->urlBase = "http://127.0.0.1:8000/api/";
    }

    public function getAllSeries()
    {
        try {
            $response = $this->get('serieAPI');
            return $this->successResponse($response->object());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function getSerieById(int $id)
    {
        try {
            $response = $this->get('serieAPI/' . $id);
            return $this->successResponse($response->object());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    public function createSerie(array $data)
    {
        try {
            $response = $this->post('serieAPI', $data);
            $body = $response->object();
            $statusCode = $body->status ?? 200;
            $mensaje = $body->mensaje ?? 'Serie creada correctamente.';

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
                ->post($this->urlBase . 'serieMasivaAPI');

            return $this->successResponse($response->object(), $response->status());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    /**
     * Actualiza una serie existente (PUT)
     *
     * @param int $id
     * @param array $data
     * @return JsonResponse
     */
    public function updateSerie(int $id, array $data)
    {
        try {
            $response = $this->put("serieAPI/{$id}", $data);
            $body = $response->object();
            $statusCode = $response->status();

            return $this->successResponse($body, $statusCode);
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }
}
