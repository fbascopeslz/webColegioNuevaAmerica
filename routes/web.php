<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*
Route::group(['middleware' => ['guest']], function(){
    Route::get('/', 'Auth\LoginController@showLoginForm');
    //login con el metodo POST es para el formulario de logeo de usuario
    Route::post('login', 'Auth\LoginController@login');
    //login con el metodo GET es para cuando caduca el tiempo de session de usuario y redirige a esta ruta
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login'); 

}); //Rutas para invitado

Route::group(['middleware' => ['auth']], function(){ //Rutas para usuario autenticado
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});
*/

Route::get('/', function () {
    return view('principal');
})->name('main'); //Alias de la ruta

Route::get('alumno', 'AlumnoController@index');
Route::post('alumno/registrar', 'AlumnoController@store');
Route::post('alumno/actualizar', 'AlumnoController@update');

Route::get('nivel', 'NivelController@index');
Route::post('nivel/registrar', 'NivelController@store');
Route::post('nivel/actualizar', 'NivelController@update');
Route::get('nivel/getNiveles', 'NivelController@getNiveles');

Route::get('curso/getCursos', 'CursoController@getCursos');

Route::get('paralelo/getParalelos', 'ParaleloController@getParalelos');

Route::get('profesor/getProfesores', 'ProfesorController@getProfesores');

Route::get('materia/getMaterias', 'MateriaController@getMaterias');

Route::get('oferta', 'OfertaController@index');
Route::get('oferta2', 'OfertaController@index2');
Route::get('oferta3', 'OfertaController@index3');
Route::post('oferta/registrar', 'OfertaController@store');

Route::get('inscripcion', 'InscripcionController@index');
Route::post('inscripcion/registrar', 'InscripcionController@store');

Route::get('cursoParalelo', 'CursoParaleloController@index');

Route::get('periodo', 'PeriodoController@index');

Route::get('monitorearAsistencia/getTablaAsistencia', 'MonitorearAsistenciaController@getTablaAsistencia');



use Maatwebsite\Excel\Facades\Excel;
//use View;
use App\Exports\BoletinNotasExport;
Route::get('boletinNotas', function() {
    //return Excel::download(new BoletinNotasExport(), 'boletinNotas.xlsx');

    //PDF file is stored under project/public/download/info.pdf
    $file = public_path(). "/boletinNotas.xlsx";

    $headers = [
        'Content-Type' => 'application/xlsx',
     ];

    return response()->download($file, 'boletinNotas.xlsx', $headers);    
});



//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
