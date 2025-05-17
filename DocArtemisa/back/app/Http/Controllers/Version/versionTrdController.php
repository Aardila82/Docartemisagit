<?php

namespace App\Http\Controllers\Version;

use App\Models\Version\versionTrdModel;
use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\Version\VersionTrdStoreRequest;
use App\Http\Requests\Version\VersionTrdUpdateRequest;

class versionTrdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        //
        $versionTrd = versionTrdModel::latest('id')->paginate(3);
        //dd($versionTrd);
        return view('Version/index',['versionTrd'=>$versionTrd]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('Version/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectREsponse
    {
        //
        $request->validate([
            'descripcion'=>'required',
            'fechainicio'=>'required',
            'estado'=>'required'
        ]);

        versionTrdModel::create($request->all());
        return redirect()->route('versionTrd.index')->with('success', 'Versi&oacute;n registrada en el sistema');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id):View
    {
        //
        $versionTrd = versionTrdModel::find($id);
        //dd($versionTrd->fechainicio);
        return view('version/update', ['versionTrd'=>$versionTrd]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, versionTrdModel $versionTrd):RedirectResponse
    {
        //
        $request->validate([
            'descripcion'=>'required',
            'fechainicio'=>'required',
            'estado'=>'required'
        ]);
        
        $versionTrd->update($request->all());
        return redirect()->route('versionTrd.index')->with('success', 'Version actualizada en el sistema');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
     /**
     * Proceso para la copia de las tablas asociadas a la version
     * Si pasa el estado de la version a inactiva se debe iniciar el proceso de copia de tablas a historico :
     *  Series
     *  Subseries
     *  Tipos documentales
     */
    public function copiaTabla(string $id)
    {
        //
    }
}
