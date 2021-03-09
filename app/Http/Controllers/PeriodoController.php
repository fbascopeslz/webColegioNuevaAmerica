<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Periodo;


class PeriodoController extends Controller
{
    public function index(Request $request)
    {        
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {            
            $periodos = Periodo::select('Periodo.Id', 'periodo.Numero', 'periodo.FechaInicio', 'periodo.FechaFin', 'periodo.Anio', 'periodo.Descripcion')
                ->orderBy('Periodo.Id', 'asc')
                ->paginate(5);
        } else {
            $periodos = Periodo::select('Periodo.Id', 'periodo.Numero', 'periodo.FechaInicio', 'periodo.FechaFin', 'periodo.Anio', 'periodo.ascripcion')                        
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->orderBy('Periodo.Id', 'desc')
                ->paginate(5);            
        }                

        return [
            'pagination' => [
                'total' => $periodos->total(),
                'current_page' => $periodos->currentPage(),
                'per_page' => $periodos->perPage(),
                'last_page' => $periodos->lastPage(),
                'from' => $periodos->firstItem(),
                'to' => $periodos->lastItem(),
            ],
            'periodos' => $periodos
        ];
    }
}
