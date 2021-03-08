<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;


class ParaleloController extends Controller
{
    
    public function getParalelos(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $idNivel = $request->idNivel;
        $idCurso = $request->idCurso;
            
        $sql = "SELECT Par.Id, Par.Nombre 
            FROM CursoParalelo CP, Curso C, Paralelo Par, Nivel N
            WHERE CP.CursoId = C.Id AND CP.ParaleloId = Par.Id AND N.Id = C.NivelId 
                AND N.Id = $idNivel AND C.Id = $idCurso
            ORDER BY Id ASC";
        $paralelos = DB::select($sql);

        return ['paralelos' => $paralelos];
    }
    
}
