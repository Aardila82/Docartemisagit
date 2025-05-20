<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class SerieService extends ApiService
{
    /**
     * URL base de la API para series
     * 
     * @var string
     */

    protected string $urlBase;

    function __construct(){
        $this->urlBase = "http://127.0.0.1:8000/api/";
    }

    /**
     * Obtiene todas las series
     * 
     * @return JsonResponse
     */
    public function getAllSeries()
    {
        try {
            $response = $this->get('serieAPI');
            return $this->successResponse($response->object());
            
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    /**
     * Obtiene una serie específica por ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function getSerieById(int $id)
    {
        try {
            $response = $this->get('serieAPI/' . $id);
            return $this->successResponse($response->object());
            
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

    /**
     * Crea una nueva serie
     * 
     * @param array $data
     * @return JsonResponse
     */
    public function createSerie(array $data)
    {
        try {
            $response = $this->post('serieAPI', $data);
            $body = $response->object();
            $statusCode = $body->status;
            $mensaje = $body->mensaje;

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
                // No usamos withHeaders() porque Laravel gestiona los headers al usar `attach`
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
}