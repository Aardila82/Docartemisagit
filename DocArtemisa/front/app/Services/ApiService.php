<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response as HttpClientResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\RequestException;

abstract class ApiService
{
    /**
     * URL base de la API
     *
     * @var string
     */
    protected string $urlBase;

    /**
     * Realiza una petición GET a la API
     */
    protected function get(string $endpoint, array $queryParams = []): HttpClientResponse
    {
        return Http::withOptions([
                'timeout' => 30,
                'max_redirects' => 10,
            ])
            ->withHeaders($this->getDefaultHeaders())
            ->get($this->urlBase . $endpoint, $queryParams);
    }

    /**
     * Realiza una petición POST a la API
     */
    protected function post(string $endpoint, array $data = []): HttpClientResponse
    {
        return Http::withOptions([
                'timeout' => 30,
                'max_redirects' => 10,
            ])
            ->withHeaders($this->getDefaultHeaders())
            ->post($this->urlBase . $endpoint, $data);
    }

    /**
     * Realiza una petición PUT a la API
     */
    protected function put(string $endpoint, array $data = []): HttpClientResponse
    {
        return Http::withOptions([
                'timeout' => 30,
                'max_redirects' => 10,
            ])
            ->withHeaders($this->getDefaultHeaders())
            ->put($this->urlBase . $endpoint, $data);
    }

    /**
     * Realiza una petición DELETE a la API
     */
    protected function delete(string $endpoint, array $data = []): HttpClientResponse
    {
        return Http::withOptions([
                'timeout' => 30,
                'max_redirects' => 10,
            ])
            ->withHeaders($this->getDefaultHeaders())
            ->delete($this->urlBase . $endpoint, $data);
    }

    /**
     * Obtiene los headers por defecto para las peticiones
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Cache-Control' => 'no-cache',
            'X-Requested-With' => 'XMLHttpRequest',
            'Content-Type' => 'application/json',
        ];
    }

    /**
     * Maneja los errores de la API
     */
    protected function handleApiError(RequestException $e): JsonResponse
    {
        $response = $e->response;
        $statusCode = $response ? $response->status() : 500;
        $errorMessage = $response ? ($response->object()->message ?? $e->getMessage()) : $e->getMessage();

        return response()->json([
            'success' => false,
            'error' => $errorMessage,
            'status' => $statusCode
        ], $statusCode);
    }

    /**
     * Formatea una respuesta exitosa
     */
    protected function successResponse($data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'status' => $statusCode
        ], $statusCode);
    }
}
