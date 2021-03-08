<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Alumno;
use App\User;


class AlumnoController extends Controller
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
            $alumnos = Alumno::join('Usuario', 'Alumno.UsuarioId', '=', 'Usuario.Id')
                ->select('Alumno.Id', 'Alumno.CI', 'Alumno.Nombre', 'Alumno.FechaNac', 
                    'Alumno.Sexo', 'Alumno.Direccion', 'Alumno.Telefono', 
                    'Alumno.Email', 'Usuario.Usuario', 'Alumno.Fotografia')
                ->orderBy('Alumno.Id', 'desc')
                ->paginate(5);
        } else {
            $alumnos = Alumno::join('Usuario', 'Alumno.UsuarioId', '=', 'Usuario.Id')
                ->select('Alumno.Id', 'Alumno.CI', 'Alumno.Nombre', 'Alumno.FechaNac', 
                    'Alumno.Sexo', 'Alumno.Direccion', 'Alumno.Telefono', 
                    'Alumno.Email', 'Usuario.Usuario', 'Alumno.Fotografia')            
                ->where($criterio, 'like', '%'.$buscar.'%')
                ->orderBy('Alumno.Id', 'desc')
                ->paginate(5);         
            
        }                

        return [
            'pagination' => [
                'total' => $alumnos->total(),
                'current_page' => $alumnos->currentPage(),
                'per_page' => $alumnos->perPage(),
                'last_page' => $alumnos->lastPage(),
                'from' => $alumnos->firstItem(),
                'to' => $alumnos->lastItem(),
            ],
            'alumnos' => $alumnos
        ];
    }

    
    public function store(Request $request)
    {
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }              
        
        $user = new User();
        $user->Usuario = $request->usuario;
        $user->Contrasenia = md5($request->password);
        $user->GrupoId = 2; // Alumno
        $user->save();
        
        $alumno = new Alumno();
        $alumno->CI = $request->ci;
        $alumno->Nombre = $request->nombre;
        $alumno->FechaNac = $request->fechaNac;
        $alumno->Sexo = $request->sexo;           
        $alumno->Direccion = $request->direccion;
        $alumno->Telefono = $request->telefono;
        $alumno->Email = $request->email;
        $alumno->UsuarioId = $user->Id;
        $alumno->save();       
    }

    
    public function update(Request $request)
    {   
        //Si la peticion no es de Ajax redirige a la ruta '/'
        if (!$request->ajax()) {
            return redirect('/');
        }

        $user = User::findOrFail($request->id);
        $user->Usuario = $request->usuario;
        $user->Contrasenia = md5($request->password);
        $user->save(); 

        $alumno = Alumno::findOrFail($request->id);       
        $alumno->CI = $request->ci;
        $alumno->Nombre = $request->nombre;
        $alumno->FechaNac = $request->fechaNac;
        $alumno->Sexo = $request->sexo;           
        $alumno->Direccion = $request->direccion;
        $alumno->Telefono = $request->telefono;
        $alumno->Email = $request->email;        
        $alumno->save();                        
    }

}
