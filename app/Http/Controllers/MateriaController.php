<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;


class MateriaController extends Controller
{
    public function getMaterias(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }

        $idNivel = $request->idNivel;
        $idCurso = $request->idCurso;
        $idParalelo = $request->idParalelo;
        $idProfesor = $request->idProfesor;
            
        $sql = "SELECT CP.Id
            FROM CursoParalelo CP, Curso C, Paralelo Par, Nivel N
            WHERE CP.CursoId = C.Id AND CP.ParaleloId = Par.Id AND N.Id = C.NivelId 
                AND N.Id = $idNivel AND C.Id = $idCurso AND Par.Id = $idParalelo
            ORDER BY Id ASC";
        $cursoParalelo = DB::select($sql);
        $idCursoParalelo = $cursoParalelo[0]->Id;

        $sql = "SELECT *
                FROM Materia M
                WHERE M.Id NOT IN(
                    SELECT O.MateriaId 
                    FROM Oferta O, Profesor P
                    WHERE O.ProfesorId = P.Id
                        AND P.Id = $idProfesor AND O.CursoParaleloId = $idCursoParalelo
                )";
        $materias = DB::select($sql);

        return ['materias' => $materias, 'idCursoParalelo' => $idCursoParalelo];
        
    }
}
