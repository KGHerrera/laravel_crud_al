<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumno::latest()->get(); // Obtener todos los alumnos sin paginación
        return view('alumnos', compact('alumnos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('insertar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([

            'Nombre' => 'required',
            'Semestre' => 'required',

        ]);

        // Registrar los valores de la solicitud en el archivo de registro
        Log::info('Valores de la solicitud:', $request->all());

        Alumno::create($request->post());
        return redirect()->route('alumnos.index')->with('success', 'Alumno creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumno $alumno)
    {
        return view('mostrar', compact('alumno'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            // Manejar el caso donde el alumno no existe
            abort(404);
        }

        return view('edit', compact('alumno'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'Nombre' => 'required',
            'Semestre' => 'required',
        ]);
    
        $alumno->Nombre = $request->input('Nombre');
        $alumno->Semestre = $request->input('Semestre');
        $alumno->save();
    
        return redirect()->route('alumnos.index')->with('success', 'Alumno modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno Eliminado correctamente');
    }
}
