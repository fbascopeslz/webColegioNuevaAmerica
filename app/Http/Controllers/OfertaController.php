<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Oferta;

use DB;


class OfertaController extends Controller
{
    //listar la lista de oferta de un solo Profesor
    public function index(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $idProfesor = $request->idProfesor;

        if ($buscar == '') {
            $ofertas = Oferta::join('Profesor', 'Oferta.ProfesorId', '=', 'Profesor.Id')
                ->join('Materia', 'Oferta.MateriaId', '=', 'Materia.Id')
                ->join('CursoParalelo', 'Oferta.CursoParaleloId', '=', 'CursoParalelo.Id')
                ->join('Paralelo', 'CursoParalelo.ParaleloId', '=', 'Paralelo.Id')
                ->join('Curso', 'CursoParalelo.CursoId', '=', 'Curso.Id')
                ->join('Nivel', 'Curso.NivelId', '=', 'Nivel.Id')
                ->select('Oferta.Id', 'Profesor.Nombre as Profesor', 'Nivel.Nombre as Nivel', 'Materia.Nombre as Materia', 
                    'Curso.Nombre as Curso', 'Paralelo.Nombre as Paralelo', 'Oferta.Gestion')
                ->where('Oferta.ProfesorId', '=', $idProfesor)
                ->orderBy('Oferta.Id', 'desc')
                ->paginate(5);
        } else {            
            $ofertas = Oferta::join('Profesor', 'Oferta.ProfesorId', '=', 'Profesor.Id')
                ->join('Materia', 'Oferta.MateriaId', '=', 'Materia.Id')
                ->join('CursoParalelo', 'Oferta.CursoParaleloId', '=', 'CursoParalelo.Id')
                ->join('Paralelo', 'CursoParalelo.ParaleloId', '=', 'Paralelo.Id')
                ->join('Curso', 'CursoParalelo.CursoId', '=', 'Curso.Id')
                ->join('Nivel', 'Curso.NivelId', '=', 'Nivel.Id')
                ->select('Oferta.Id', 'Profesor.Nombre as Profesor', 'Nivel.Nombre as Nivel', 'Materia.Nombre as Materia', 
                    'Curso.Nombre as Curso', 'Paralelo.Nombre as Paralelo', 'Oferta.Gestion')
                ->where($criterio, 'like', '%'.$buscar.'%') //Pendiente la busqueda
                ->andWhere('Oferta.ProfesorId', '=', $idProfesor)
                ->orderBy('Oferta.Id', 'desc')
                ->paginate(5);             
        }                

        return [
            'pagination' => [
                'total' => $ofertas->total(),
                'current_page' => $ofertas->currentPage(),
                'per_page' => $ofertas->perPage(),
                'last_page' => $ofertas->lastPage(),
                'from' => $ofertas->firstItem(),
                'to' => $ofertas->lastItem(),
            ],
            'ofertas' => $ofertas
        ];
    }    

    public function store(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }              
                    
        try {
            DB::beginTransaction();
           
            $arrayOfertas = $request->arrayOfertas; //array de Ofertas

            foreach($arrayOfertas as $ep => $ofe)
            {
                $oferta = new Oferta();
                $oferta->MateriaId = $ofe['MateriaId'];
                $oferta->ProfesorId = $ofe['ProfesorId'];
                $oferta->CursoParaleloId = $ofe['CursoParaleloId'];
                $oferta->Gestion = 2021;                              
                $oferta->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
        }               
    }

}
