<?php
/**
 * Created by PhpStorm.
 * User: Hoang Dai
 * Date: 08/05/2017
 * Time: 13:52
 */

namespace App\Http\Controllers;

use App\CusstomPHP\CurrentUser;
use App\CusstomPHP\CustomURL;
use App\CusstomPHP\Response;
use App\CusstomPHP\Tables;
use App\CusstomPHP\Time;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SaoLuuController extends Controller
{
    public function saoluu()
    {
        $files=File::allFiles('public/backup');
        $data=[];
        $i=0;
        foreach($files as $item){
            if(File::extension((string)$item)=='sql'){
                $data[$i]=[];
                $data[$i]['name']=(string)$item;
                $data[$i]['size']=intval(intval(File::size((string)$item))/1024) . " KB";
                $data[$i]['time']=Carbon::createFromTimestamp(File::lastModified((string)$item),"Asia/Ho_Chi_Minh")->format("H:i d/m/Y");
                $i++;
            }
        }

        return view('page.saoluu.saoluu', [
            'files'=>$data,
        ]);
    }
}