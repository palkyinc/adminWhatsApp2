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

Route::get('/', function () {return view('livewire/home');});

Route::post('/whatssAppWebHoo', function (Request $request) {
    MyFunctions::loguear('a+', '../storage/logs/entidades.txt', MyFunctions::iterator($request->all()), false);
    //$toSend = new TestWhats($request);
    //Mail::to('migvicpereyra@hotmail.com')->queue($toSend);
    MyFunctions::loguear('a', '../storage/logs/whatsresponse.txt', 'contacto');
    //dd($request->all());
    return response('', 200);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
