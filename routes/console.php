<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\PathController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('report {project}', function(){
    $project = $this->argument('project');
    $pc = new PathController();
    $pc->toMsWord($project);
});

Artisan::command('project-list', function(){
    $pc = new PathController();
    print_r($pc->getReportBase());
});

Artisan::command('resize-image {project}', function(){
    $project = $this->argument('project');
    $images = ImageController::resizeImage($project);
});