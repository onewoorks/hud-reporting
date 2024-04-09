<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\PhpWord;
class PathController extends Controller
{

    private $point_path;
    private $daily;
    private $locations;
    private $progress;

    public function __construct(){
        $this->point_path = storage_path().'/output/';
        // $this->point_path = public_path().'/storage/raw_images/';
    }

    public function toMsWord($project){
        $report_path = $this->getReportPath($project);
        $data = $report_path->getData();
        $reports = $data['reports'];
        $header_title = $data['report_title'];
        $footer_title = $data['report_footer'];
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontSize(11);
        $phpWord->setDefaultFontName('calibri');
        
        $phpWord->addNumberingStyle(
            'multilevel',
            array(
                'type' => 'multilevel',
                'levels' => array(
                    array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360),
                    array('format' => 'lowerLetter', 'text' => '%2.', 'left' => 820, 'hanging' => 360, 'tabPos' => 820),
                )
            )
        );
        foreach($reports as $report){
            foreach($report as $loc=>$status){
                echo "\tCreating : " . $loc . PHP_EOL;
                $section = $phpWord->addSection([
                    'marginRight' => 1077,
                    'marginLeft' => 1077
                ]);
                $header = $section->addHeader();
                $footer = $section->addFooter();
                $header->addText(htmlspecialchars($header_title, ENT_COMPAT, 'UTF-8'),[],['align'=> 'end']);
                $footer->addText(htmlspecialchars($footer_title, ENT_COMPAT, 'UTF-8'),[],['align' => 'center']);
                $section->addListItem(htmlspecialchars($loc, ENT_COMPAT, 'UTF-8'),0, null, 'multilevel');
                foreach($status as $stat=>$progress){
                    $section->addListItem(strtoupper($stat),1,null, 'multilevel');
                    $section->addTextBreak(1);
                    $image_rows = array_chunk($progress,2);
                    foreach($image_rows as $images){
                        $textrun = $section->addTextRun();
                        foreach($images as $image){
                            $textrun->addImage(file_get_contents(storage_path().$image),[
                                            'heigth' => 178.583,
                                            'width' => 237.5433,
                                        ]);
                            $textrun->addText('  ');
                        }
                        $section->addTextBreak(1);
                    }
                }
            }
        }
        
          
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $filename = sprintf("%s_%s.docx", strtoupper(date('Y-m-d')), $project);
        $objWriter->save(storage_path().'/reports/'.$filename);
        echo "Generate Report Completed";
        // return response()->download(public_path($filename));
    }

    public function getReportBase(){
        $dirs   = File::directories($this->point_path);
        $base   = [];
        foreach($dirs as $dir){
            $base[] = str_replace($this->point_path, '', $dir);
        }
        return $base;
    }

    public function getReportPath($project){
        $dirs   = File::directories($this->point_path.$project);
        $report = [];
        foreach($dirs as $report_day){
            $report[] = $this->reportDay($report_day, $project);
        }
        $this->daily = $report;
        $locations = [];
        foreach($report as $day){
            $locations[$day] = $this->reportLocations($day, $project);
        }
        $memo = $this->readMemo($project);
        $data = [
            'reports' => $locations,
            'report_title' => $memo->header,
            'report_footer' => $memo->footer,
        ];
        return view('pages.report', $data);
    }

    public function getRawImagesPath($project){
        $dirs   = File::directories(storage_path().'/raw_images/'.$project);
        $report = [];
        foreach($dirs as $report_day){
            $report[] = $this->reportDay($report_day, $project);
        }
        $this->daily = $report;
        $locations = [];
        foreach($report as $day){
            $locations[$day] = $this->reportLocations($day, $project);
        }
        $memo = $this->readMemo($project);
        $data = [
            'reports' => $locations,
            'report_title' => $memo->header,
            'report_footer' => $memo->footer,
        ];
        return $data;
    }

    private function reportDay($full_path, $project){
        return str_replace($this->point_path.$project, '', $full_path);
    }

    private function readMemo($project){
        // dd($this->point_path.$project.'/MEMO.txt');
        $contents = File::get($this->point_path.$project.'/NOTE.txt');
        $text_data = explode("\r\n", $contents);
        $text_data = array_filter($text_data);
        $header = "";
        $footer = "";
        foreach($text_data as $text){
            if(Str::contains($text, 'HEADER')){
                $header = str_replace('HEADER : ','',$text);
            }
            if(Str::contains($text, 'FOOTER')){
                $footer = str_replace('FOOTER : ','',$text);
            }
        }
        return (object) [
            'header'    => $header,
            'footer'    => $footer
        ];
    }

    private function reportLocations($daily, $project){
        $dirs = File::directories($this->point_path.$project.$daily);
        $locations = [];
        foreach($dirs as $location){
            $sort_name          = explode(" ", $daily);
            $location_name_raw  = str_replace($this->point_path.$daily.'/','',$location); 
            $location_name      = explode(" ", $location_name_raw); 
            $clean_loc_name     = array_slice($location_name,1);
            $clean_loc_name     = implode(" ",$clean_loc_name);

            //this if order unsortted
            $c = str_replace($this->point_path,"", $location_name_raw);
            $d = explode('/',$c);
            $e = explode(" ", $d[2]);
            // $clean_loc_name = sprintf("%s/%s/%s",$d[0],$e[1],$d[2]);
            unset($e[0]);
            $clean_loc_name = sprintf("%s",implode(" ", $e));
            // dd($clean_loc_name);
            $locations[$clean_loc_name] = $this->reportProgress($location);
        }
        return $locations;
    }

    private function reportProgress($location){
        $progresses = [
            'sebelum'   => $this->reportImages(File::allFiles($location.'/SEBELUM'), $location, '/SEBELUM'),
            'semasa'    => $this->reportImages(File::allFiles($location.'/SEMASA'), $location,'/SEMASA'),
            'selepas'   => $this->reportImages(File::allFiles($location.'/SELEPAS'), $location,'/SELEPAS'),
        ];        
        return $progresses;
    }

    private function reportImages($files, $location, $progress, $max_image = 4){
        $images = [];
        $path = str_replace($this->point_path, '/output/', $location);
        foreach($files as $i=>$file){
            if($i<$max_image){
                $im = pathinfo($file);
                $images[] = $path.$progress.'/'.$im['basename'];
            }
        }
        return $images;
    }

    private function reportGenerator(){
        
    }
}
