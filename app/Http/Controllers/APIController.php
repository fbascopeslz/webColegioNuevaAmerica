<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;


class APIController extends Controller
{
    public function registrarAsistencia(Request $request)
    {        
        $listaAsistencia = json_decode($request->input("listaAsistencia"), true);
             
        try {
            $array = [];

            for ($i=0; $i < count($listaAsistencia); $i++) {                                                   
                $array[] = [
                    'Fecha' => date('Y-m-d'), 
                    'Hora' => date('H:i:s'), 
                    'IdTipoAsistencia' => $listaAsistencia[$i]["IdTipoAsistencia"],
                    'IdOferta' => $listaAsistencia[$i]["IdOferta"],
                    'IdAlumno' => $listaAsistencia[$i]["IdAlumno"],
                    'IdPeriodo' => $listaAsistencia[$i]["IdPeriodo"]
                ]; 
            }
            
            DB::table('Asistencia')->insert(
                $array
            );                                    

            return response()->json(1);                                           
            
        } catch (\Throwable $th) {                  
            return response()->json(
                $th->getCode()
            );  
       }        
    }
}
