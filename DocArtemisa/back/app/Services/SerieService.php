<?php

namespace App\Services;

use App\Models\Serie\SerieModel;
use Illuminate\Support\Facades\Validator;
use App\Services\SeriesCargueMasivaService;
use Illuminate\Support\Facades\File;

class SerieService
{

    protected $seriesCargueMasivaService;


    public function __construct(
        seriesCargueMasivaService $SeriesCargueMasivaService
    ) {
        $this->seriesCargueMasivaService = $SeriesCargueMasivaService;
    }

public function importFromCSV($filePath)
    {
        try {
            $file = file($filePath);
            $cantidadRegistros = count($file);

            $dataInicial = [
                'cantidad_registros' => $cantidadRegistros,
                'nombre_archivo' => File::basename($filePath),
                'nombre_usuario' => 'ARSUAREZ',
                'mensaje_error' => '',
                'peso' => File::size($filePath),
            ];

            $this->seriesCargueMasivaService->store((Object)$dataInicial);

            // Leer el archivo CSV
            $csvData = array_map('str_getcsv', $file);

            // Eliminar la cabecera si existe
            $header = array_shift($csvData);

            $results = [
                'imported' => 0,
                'errors' => [],
                'total_rows' => count($csvData)
            ];

            foreach ($csvData as $index => $row) {
                $result = $this->processRow($row, $index);

                if ($result['success']) {
                    $results['imported']++;
                } else {
                    $results['errors'][] = $result['error'];
                }
            }

            return $results;

        } catch (\Exception $e) {
            $dataError = $dataInicial ?? [];
            $dataError['mensaje_error'] = $e->getMessage();
            $this->seriesCargueMasivaService->store((Object)$dataError);

            return [
                'imported' => 0,
                'errors' => [$e->getMessage()],
                'total_rows' => 0,
            ];
        }
    }

    protected function processRow($row, $rowNumber)
    {
        $data = [
            'codigo' => $row[0] ?? null,
            'descripcion' => $row[1] ?? null,
            'fechainicio' => $row[2] ?? null,
            'fechafin' => $row[3] ?? null,
        ];

        // Validar los datos del registro
        $validator = Validator::make($data, [
            'codigo' => 'required|integer',
            'descripcion' => 'required|string',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'error' => [
                    'row_number' => $rowNumber + 1, // +1 porque el array empieza en 0
                    'row_data' => $row,
                    'errors' => $validator->errors()->toArray()
                ]
            ];
        }

        // Verificar si ya existe una serie con el mismo código y descripción
        $existe = SerieModel::where('codigo', $data['codigo'])
            ->where('descripcion', $data['descripcion'])
            ->where('estado_id', '!=', 2)
            ->exists();

        if ($existe) {
            return [
                'success' => false,
                'error' => [
                    'row_number' => $rowNumber + 1,
                    'row_data' => $row,
                    'errors' => ['conflicto' => 'Ya existe una serie con este código y descripción']
                ]
            ];
        }

        // Crear el registro
        try {
            SerieModel::create($data);
            return ['success' => true];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => [
                    'row_number' => $rowNumber + 1,
                    'row_data' => $row,
                    'errors' => ['exception' => $e->getMessage()]
                ]
            ];
        }
    }
}
