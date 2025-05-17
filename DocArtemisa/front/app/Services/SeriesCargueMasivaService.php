<?php

namespace App\Services;
use Illuminate\Http\Client\RequestException;

class SeriesCargueMasivaService extends ApiService
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

    public function getAll()
    {
        try {
            $response = $this->get('SeriesCargueMasivaAPI');
            return $this->successResponse($response->object());
        } catch (RequestException $e) {
            return $this->handleApiError($e);
        }
    }

}