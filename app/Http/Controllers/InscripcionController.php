<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Inscripcion;


class InscripcionController extends Controller
{
    //listar la lista de oferta de un solo Profesor
    public function index(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $idAlumno = $request->idAlumno;

        $inscripcion = Inscripcion::join('CursoParalelo AS CP', 'Inscripcion.CursoParaleloId', '=', 'CP.Id')
            ->join('Curso AS C', 'CP.CursoId', '=', 'C.Id')
            ->join('Paralelo AS P', 'CP.ParaleloId', '=', 'P.Id')
            ->join('Nivel AS N', 'C.NivelId', '=', 'N.Id')            
            ->select('Inscripcion.Id', 'N.Nombre AS Nivel', 'C.Nombre AS Curso', 'P.Nombre AS Paralelo', 
                'Inscripcion.Gestion')
            ->where('Inscripcion.AlumnoId', '=', $idAlumno)            
            ->get();
        
        if (count($inscripcion) >= 1) {
            return $inscripcion;
        } else {
            return "El estudiante no tiene inscripcion para esta gestion";
        }                            
    }    
    
    public function store(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }              
        
        $idAlumno = $request->idAlumno;
        $idCursoParalelo = $request->idCursoParalelo;

        $inscripcion = new Inscripcion();
        $inscripcion->Fecha = date('Y-m-d H:i:s');
        $inscripcion->CursoParaleloId = $idCursoParalelo;
        $inscripcion->AlumnoId = $idAlumno;        
        $inscripcion->Gestion = 2020;
        $inscripcion->save();              
    }
    
}
