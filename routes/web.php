<?php

use App\Http\Controllers\PathController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $pc     = new PathController();
    $data   = [
        'report_base' => $pc->getReportBase()
    ];
    return view('project-list', $data);
});

Route::prefix('/project')->group(function(){
    Route::get('/report/{project}', [PathController::class, 'toMsWord']);
    Route::get('/{project}', [PathController::class, 'getReportPath']);
});