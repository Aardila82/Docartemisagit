<?php

namespace App\Http\Controllers;

use App\Models\Artactastrd;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class Actascontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //
        $actas = Artactastrd::latest('id')->paginate(3);
        return view('index',['actas'=>$actas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('createacta');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $request->validate([
            'title'=>'required',
            'descripcion'=>'required',
            'fecha'=>'required',
            'estado'=>'required'
            
        ]);

        Artactastrd::create($request->all());
        return redirect()->route('acta.index')->with('success', 'Acta registrada en el sistema');

    }

    /**
     * Display the specified resource.
     */
    public function show(Artactastrd $artactstrd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        //
        
        $acta = Artactastrd::find($id);
        return view('updateacta', ['acta'=>$acta]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artactastrd $artactstrd): RedirectResponse
    {
        //
        $request->validate([
            'title'=>'required',
            'descripcion'=>'required',
            'fecha'=>'required',
            'estado'=>'required'
            
        ]);

        $artactstrd->update($request->all());
        return redirect()->route('acta.index')->with('success', 'Acta actualizada en el sistema');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artactastrd $artactstrd)
    {
        //
    }
}
