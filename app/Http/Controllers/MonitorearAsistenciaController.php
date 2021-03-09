<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;


class MonitorearAsistenciaController extends Controller
{
    public function getTablaAsistencia(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }        

        $idAlumno = $request->idAlumno;
        $idOferta = $request->idOferta;
        $idPeriodo = $request->idPeriodo;
        $numeroMes = $request->numeroMes;                    

        $sql = "SELECT a.fecha , ta.Letra as letra, MONTH(a.fecha) as mes, DAY(a.fecha) as dia, DATENAME(dw, a.fecha) as diaSemana
                FROM Asistencia a, Oferta o, Alumno alu, Periodo p, TipoAsistencia ta 
                WHERE a.IdOferta = o.Id AND a.IdAlumno = alu.Id AND a.IdPeriodo = p.Id AND a.IdTipoAsistencia = ta.Id 
                    AND a.IdAlumno = $idAlumno AND a.IdOferta = $idOferta AND a.IdPeriodo = $idPeriodo
                    AND MONTH(a.fecha) = $numeroMes";        
        $asistencia = DB::select($sql);

        return ['asistencia' => $asistencia];
        
    }
}
