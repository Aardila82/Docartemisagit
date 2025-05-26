<?php

namespace App\Services;

use App\Models\SubSerie\SubSerieVersionModel;
use App\Models\Serie\SerieModel;

use Illuminate\Support\Facades\Validator;
use App\Services\SubSeriesCargueMasivaService;
use Illuminate\Support\Facades\File;



class SubSerieService
{

    protected $subSeriesCargueMasivaService;


    public function __construct(
        SubSeriesCargueMasivaService $subSeriesCargueMasivaService
    ) {
        $this->subSeriesCargueMasivaService = $subSeriesCargueMasivaService;
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

            $query = SubSerieVersionModel::with(['estado', 'serieVersion']);

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

            $data = SubSerieVersionModel::find($id);

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

        return SubSerieVersionModel::find($id);
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

            $this->subSeriesCargueMasivaService->store((object)$dataInicial);

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
            $this->subSeriesCargueMasivaService->store((object)$dataError);

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
        $existe = SubSerieVersionModel::where('codigo', $data['codigo'])
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
            SubSerieVersionModel::create($data);
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


    public function store(array $data)
    {
        $validator = Validator::make($data, [
            'id_codigo_serie'     => 'required|integer',
            'codigo_subserie'     => 'required|integer',
            'descripcion'         => 'required|string|max:255',
            'fecha_inicio'        => 'required|date',
            'fecha_final'         => 'required|date|after_or_equal:fecha_inicio',
            'archivo_gestion'     => 'nullable|boolean',
            'archivo_central'     => 'nullable|boolean',
            'conservacion_total'  => 'nullable|boolean',
            'eliminacion'         => 'nullable|boolean',
            'microfilmacion'      => 'nullable|boolean',
            'seleccion'           => 'nullable|boolean',
            'procedimiento'       => 'nullable|string|max:1000',
            'version'             => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return [
                'data' => [],
                'errors' => $validator->errors(),
                'status' => 422
            ];
        }
        $validated = $validator->validated();

        $duplicado = SubSerieVersionModel::where('id_codigo_serie', $validated['id_codigo_serie'])
            ->where('codigo_subserie', $validated['codigo_subserie'])
            ->where('descripcion', $validated['descripcion'])
            ->exists();

        if ($duplicado) {
            return [
                'data' => [],
                'errors' => ['Ya existe una subserie con esa combinación de id_codigo_serie, codigo_subserie y descripción.'],
                'status' => 409
            ];
        }

        $serieExiste = SerieModel::find($validated['id_codigo_serie']);
        if (!$serieExiste) {
            return [
                'data' => [],
                'errors' => ['El id_codigo_serie no existe en la tabla serieversion.'],
                'status' => 404
            ];
        }

        try {
            $subSerie = SubSerieVersionModel::create($validator->validated());

            return [
                'data' => [['id' => $subSerie->id]],
                'errors' => [],
                'status' => 200
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'errors' => [$e->getMessage()],
                'status' => 500
            ];
        }
    }

    public function update(array $data, int $id)
    {
        $subSerie = SubSerieVersionModel::find($id);

        if (!$subSerie) {
            return [
                'data' => [],
                'errors' => ['Registro con ID proporcionado no encontrado.'],
                'status' => 404
            ];
        }

        // Validar datos base
        $validator = Validator::make($data, [
            'id_codigo_serie'     => 'required|integer',
            'codigo_subserie'     => 'required|integer',
            'descripcion'         => 'required|string|max:255',
            'fecha_inicio'        => 'required|date',
            'fecha_final'         => 'required|date|after_or_equal:fecha_inicio',
            'archivo_gestion'     => 'nullable|boolean',
            'archivo_central'     => 'nullable|boolean',
            'conservacion_total'  => 'nullable|boolean',
            'eliminacion'         => 'nullable|boolean',
            'microfilmacion'      => 'nullable|boolean',
            'seleccion'           => 'nullable|boolean',
            'procedimiento'       => 'nullable|string|max:1000',
            'version'             => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return [
                'data' => [],
                'errors' => $validator->errors(),
                'status' => 422
            ];
        }

        $validated = $validator->validated();

        // Validar existencia de la serie
        $serieExiste = SerieModel::find($validated['id_codigo_serie']);
        if (!$serieExiste) {
            return [
                'data' => [],
                'errors' => ['El id_codigo_serie no existe en la tabla serieversion.'],
                'status' => 404
            ];
        }

        // Validar combinación única (excluyendo el registro actual)
        $duplicado = SubSerieVersionModel::where('id_codigo_serie', $validated['id_codigo_serie'])
            ->where('codigo_subserie', $validated['codigo_subserie'])
            ->where('descripcion', $validated['descripcion'])
            ->exists();

        if ($duplicado) {
            return [
                'data' => [],
                'errors' => ['Ya existe una subserie con esa combinación de id_codigo_serie, codigo_subserie y descripción.'],
                'status' => 409
            ];
        }

        // Actualizar el registro
        try {
            $subSerie->update($validated);

            return [
                'data' => [['id' => $subSerie->id]],
                'errors' => [],
                'status' => 200
            ];
        } catch (\Exception $e) {
            return [
                'data' => [],
                'errors' => [$e->getMessage()],
                'status' => 500
            ];
        }
    }
}
