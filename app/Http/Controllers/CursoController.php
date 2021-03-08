<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Curso;


class CursoController extends Controller
{
    public function getCursos(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $idNivel = $request->idNivel;        
                
        $cursos = Curso::where('NivelId', '=', $idNivel)
            ->orderBy('Id', 'asc')
            ->get();                         

        return ['cursos' => $cursos];
    }
}
