<?php

namespace App\Services;

use App\Models\Serie\SerieModel;
use Illuminate\Support\Facades\Validator;
use App\Services\SeriesCargueMasivaService;
use Illuminate\Support\Facades\File;
use App\Services\LogEventoService;


class SerieService
{

    protected $seriesCargueMasivaService;
    protected $logEventoService;
    protected $evento_id_create;
    protected $evento_id_edit;
    protected $evento_id_delete;
    protected $entidad_id;
    protected $user;


    public function __construct(
        seriesCargueMasivaService $SeriesCargueMasivaService
    ) {
        $this->seriesCargueMasivaService = $SeriesCargueMasivaService;
        $this->evento_id_create = 1;
        $this->evento_id_edit = 2;
        $this->evento_id_delete = 3;
        $this->entidad_id = 3;
        $this->user = "USER";

    }


    public function getAll($params)
    {
        try {
            $validator = Validator::make($params, [
                'estado_id' => 'sometimes|integer',
                'per_page' => 'sometimes|integer|min:1|max:1000',
                'page' => 'sometimes|integer|min:1'
            ]);

            if ($validator->fails()) {
                return [
                    'data' => [],
                    'errors' => $validator->errors(),
                    'status' => 422
                ];
            }
            $validated = $validator->validated();

            $query = SerieModel::with(['estado']);

            // Aplicar filtros
            if (!empty($params['estado_id'])) {
                $query->where('estado_id', $params['estado_id']);
            }

            // Paginación (10 por defecto)
            $perPage = $validated['per_page'] ?? 10;
            $data = $query->paginate($perPage);

            return [
                'data' => [
                    'data' => $data->items(),
                    'meta' => [
                        'total' => $data->total(),
                        'per_page' => $data->perPage(),
                        'current_page' => $data->currentPage(),
                        'last_page' => $data->lastPage(),
                        'from' => $data->firstItem(),
                        'to' => $data->lastItem()
                    ]

                ],
                'errors' => [],
                'status' => 500
            ];
        } catch (\Exception $e) {

            return [
                'data' => [],
                'errors' => $e->getMessage(),
                'status' => 500
            ];
        }
    }

    public function show($id)
    {
        try {

            $data = SerieModel::find($id);

            return [
                'data' => $data,
                'errors' => [],
                'status' => 500
            ];
            return response()->json($data);
        } catch (\Exception $e) {

            return [
                'data' => [],
                'errors' => $e->getMessage(),
                'status' => 500
            ];
        }

        return SerieModel::find($id);
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

            $this->seriesCargueMasivaService->store((object)$dataInicial);

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
            $this->seriesCargueMasivaService->store((object)$dataError);

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

    public function update(int $id, array $data): array
    {
        // Validar los datos entrantes
        $validator = Validator::make($data, [
            'codigo' => 'required|integer',
            'descripcion' => 'required|string',
            'fechainicio' => 'required|date',
            'fechafin' => 'required|date|after_or_equal:fechainicio',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ];
        }

        try {
            // Buscar la serie por ID
            $serie = SerieModel::findOrFail($id);

            // Verificar si existe otra serie con el mismo código y descripción (evitando conflicto con sí misma)
            $existe = SerieModel::where('id', '!=', $id)
                ->where('codigo', $data['codigo'])
                ->where('descripcion', $data['descripcion'])
                ->where('estado_id', '!=', 2)
                ->exists();

            if ($existe) {
                return [
                    'success' => false,
                    'errors' => ['conflicto' => 'Ya existe otra serie con este código y descripción']
                ];
            }

            // Actualizar la serie
            $serie->update($data);

            return [
                'success' => true,
                'data' => $serie
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => ['exception' => $e->getMessage()]
            ];
        }
    }
    public function updateSerie($id, array $data)
    {
        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->put(env('API_SERIE_URL') . "/series/{$id}", [
                'json' => $data,
            ]);

            return response()->json(json_decode($response->getBody()->getContents()), $response->getStatusCode());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $statusCode = $e->getResponse() ? $e->getResponse()->getStatusCode() : 500;
            $message = $e->getResponse()
                ? json_decode($e->getResponse()->getBody()->getContents(), true)
                : ['error' => 'Error de conexión con la API'];

            return response()->json($message, $statusCode);
        }
    }
}
