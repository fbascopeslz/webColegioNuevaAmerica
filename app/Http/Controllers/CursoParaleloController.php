<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CursoParalelo;


class CursoParaleloController extends Controller
{
    //listar la lista de oferta de un solo Profesor
    public function index(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;        

        if ($buscar == '') {
            $cursosParalelos = CursoParalelo::join('Curso', 'CursoParalelo.CursoId', '=', 'Curso.Id')
                ->join('Paralelo', 'CursoParalelo.ParaleloId', '=', 'Paralelo.Id')
                ->join('Nivel', 'Curso.NivelId', '=', 'Nivel.Id')
                ->select('CursoParalelo.Id', 'Nivel.Nombre as Nivel', 'Curso.Nombre as Curso', 'Paralelo.Nombre as Paralelo')                
                ->orderBy('CursoParalelo.Id', 'asc')
                ->paginate(10);
        } else {            
            $cursosParalelos =  CursoParalelo::join('Curso', 'CursoParalelo.CursoId', '=', 'Curso.Id')
                ->join('Paralelo', 'CursoParalelo.ParaleloId', '=', 'Paralelo.Id')
                ->join('Nivel', 'Curso.NivelId', '=', 'Nivel.Id')
                ->select('CursoParalelo.Id', 'Nivel.Nombre as Nivel', 'Curso.Nombre as Curso', 'Paralelo.Nombre as Paralelo')
                ->where($criterio, 'like', '%'.$buscar.'%')                
                ->orderBy('CursoParalelo.Id', 'asc')
                ->paginate(10);             
        }                

        return [
            'pagination' => [
                'total' => $cursosParalelos->total(),
                'current_page' => $cursosParalelos->currentPage(),
                'per_page' => $cursosParalelos->perPage(),
                'last_page' => $cursosParalelos->lastPage(),
                'from' => $cursosParalelos->firstItem(),
                'to' => $cursosParalelos->lastItem(),
            ],
            'cursosParalelos' => $cursosParalelos
        ];
    } 
}
