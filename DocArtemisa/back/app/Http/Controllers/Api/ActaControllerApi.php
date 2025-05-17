<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artactastrd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class ActaControllerApi extends Controller
{
    //
  public function index(Request $request)
{
    $perPage = $request->get('per_page', 10); // Valor por defecto: 10
    $page = $request->get('page', 1);         // Valor por defecto: 1

    // Usamos Eloquent directamente con paginación
    $actas = Artactastrd::latest('id')->paginate($perPage, ['*'], 'page', $page);

    // Validamos si no hay ningún registro en toda la tabla
    if ($actas->total() === 0) {
        $data = [
            "mensaje" => "No se tienen datos",
            "status" => 200
        ];
    } else {
        $data = [
            "actas" => $actas->items(), // registros solo de la página actual
            "current_page" => $actas->currentPage(),
            "last_page" => $actas->lastPage(),
            "per_page" => $actas->perPage(),
            "total" => $actas->total(),
            "next_page_url" => $actas->nextPageUrl(),
            "prev_page_url" => $actas->previousPageUrl(),
            "status" => 200
        ];
    }

    return response()->json($data, 200);
}
    //===================================

    public function show($id){
        //
        $actas = Artactastrd::find($id);
        //validar si no hay informacion
        $data=[
                "actas" =>$actas,
                "status"=> 200
            ];


       return response()->json($data,200);
    }


    //====================================

    public function store(Request $request){


        $validator = Validator::make($request->all(),[
            'title'=>'required',
            'descripcion'=>'required',
            'fecha'=>'required',
            'estado'=>'required'

        ]);


        if ($validator->fails()){
            $data=[
                "mensaje" =>"Error en la infomacion diligenciada",
                'errors' => $validator->errors(),
                "status"=> 400
            ];
        }else{
            $acta=Artactastrd::create($request->all());

            $data=[
                "mensaje" =>"crada el acta con la info diligenciada",
                "errors" => $acta,
                "status"=> 200
            ];
        }


       //*/


        return response()->json($data,200);

    }

    //=======================================
    public function update(Request $request, $id){
        $acta = Artactastrd::find($id);
        if(!$acta){

            $data=[
                "mensaje" =>"Acta no encontrada ",
                "status"=> 404
            ];

        }else{

            $validator = Validator::make($request->all(),[
                'title'=>'required',
                'descripcion'=>'required',
                'fecha'=>'required',
                'estado'=>'required'

            ]);


            if ($validator->fails()){
                $data=[
                    "mensaje" =>"Error en la infomacion diligenciada",
                    'errors' => $validator->errors(),
                    "status"=> 400
                ];
            }else{
                $acta->title = $request->title;
                $acta->descripcion=$request->descripcion;
                $acta->fecha=$request->fecha;
                $acta->estado=$request->estado;
                $acta->save();

                $data=[
                    "mensaje" =>"Acta actualizada con la info diligenciada",
                    "errors" => $acta,
                    "status"=> 200
                ];
            }
        }

        return response()->json($data,200);
    }

    //=====================================================
    public function updatePartial(Request $request, $id){
        $acta = Artactastrd::find($id);
        if(!$acta){

            $data=[
                "mensaje" =>"Acta no encontrada ",
                "status"=> 404
            ];

        }else{

            $validator = Validator::make($request->all(),[
                'title'=>'max:255',
                'descripcion'=>'max:255',
                'fecha'=>'max:11',
                'estado'=>'max:20'

            ]);


            if ($validator->fails()){
                $data=[
                    "mensaje" =>"Error en la infomacion diligenciada",
                    'errors' => $validator->errors(),
                    "status"=> 400
                ];
            }else{
                if($request->has('title')){
                    $acta->title = $request->title;
                }
                if($request->has('descripcion')){
                    $acta->descripcion=$request->descripcion;
                }
                if($request->has('fecha')){
                    $acta->fecha=$request->fecha;
                }
                if ($request->has('estado')){
                $acta->estado=$request->estado;
                }
                $acta->save();

                $data=[
                    "mensaje" =>"Acta actualizada con la info diligenciada",
                    "errors" => $acta,
                    "status"=> 200
                ];
            }
        }

        return response()->json($data,200);
    }

}
