<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Profesor;


class ProfesorController extends Controller
{
    public function getProfesores(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $profesores = Profesor::orderBy('Id', 'asc')
                ->get();
        } else {
            $profesores = Profesor::where($criterio, 'like', '%'.$buscar.'%')
                ->orderBy('Id', 'asc')
                ->get();         
        }        

        return ['profesores' => $profesores];
    }
}
