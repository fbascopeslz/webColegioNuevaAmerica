<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Nivel;


class NivelController extends Controller
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
            $niveles = Nivel::select('Nivel.Id','Nivel.Nombre')
                ->orderBy('Nivel.Id', 'desc')
                ->paginate(5);
        } else {
            $niveles = Nivel::select('Nivel.Id','Nivel.Nombre')                         
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->orderBy('Nivel.Id', 'desc')
                ->paginate(5);            
        }                

        return [
            'pagination' => [
                'total' => $niveles->total(),
                'current_page' => $niveles->currentPage(),
                'per_page' => $niveles->perPage(),
                'last_page' => $niveles->lastPage(),
                'from' => $niveles->firstItem(),
                'to' => $niveles->lastItem(),
            ],
            'niveles' => $niveles
        ];
    }

    public function getNiveles(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            //return redirect('/');
        }
     
        $niveles = Nivel::orderBy('Id', 'asc')
            ->get();
        
        return ['niveles' => $niveles];
    }

    public function store(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }              
        
        $nivel = new Nivel();
        $nivel->Nombre = $request->Nombre;
        $nivel->save();           
    }

    
    public function update(Request $request)
    {   
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }

        $nivel = Nivel::findOrFail($request->id);               
        $nivel->Nombre = $request->Nombre;
        $nivel->save();                        
    }

}
