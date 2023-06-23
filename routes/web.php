<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
Route::get('/guru/detail/{id_guru}', [GuruController::class, 'detail'])->name('guru.detail');
Route::get('/guru/add', [GuruController::class, 'add'])->name('guru.add');
Route::post('/guru/insert', [GuruController::class, 'insert'])->name('guru.insert');
Route::get('/guru/edit/{id_guru}', [GuruController::class, 'edit'])->name('guru.edit');
Route::post('/guru/update/{id_guru}', [GuruController::class, 'update'])->name('guru.update');
Route::get('/guru/delete/{id_guru}', [GuruController::class, 'delete'])->name('guru.delete');
Route::get('/guru/print', [GuruController::class, 'printAllPDF'])->name('guru.printAllPDF');
Route::get('/guru/excel', [GuruController::class, 'printAllExcel'])->name('guru.printAllExcel');
