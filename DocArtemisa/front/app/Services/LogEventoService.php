<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class LogEventoService
{
    protected string $urlBase;

    public function __construct()
    {
        $this->urlBase = "http://127.0.0.1:8000/api/";
    }

    public function getAll(): array
{
    try {
        $response = Http::get($this->urlBase . 'log-eventos');

        if ($response->successful()) {
            return $response->json() ?? [];
        }

        return [];
    } catch (RequestException $e) {
        return [];
    }
}

}
