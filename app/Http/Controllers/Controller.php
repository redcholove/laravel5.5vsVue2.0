<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Eloquent\PFiles;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    //上傳圖片用
    public function get_full_url() {
        $https = ! empty ( $_SERVER ['HTTPS'] ) && strcasecmp ( $_SERVER ['HTTPS'], 'on' ) === 0 || ! empty ( $_SERVER ['HTTP_X_FORWARDED_PROTO'] ) && strcasecmp ( $_SERVER ['HTTP_X_FORWARDED_PROTO'], 'http' ) === 0;
        return ($https ? 'http://' : 'http://') . (! empty ( $_SERVER ['REMOTE_USER'] ) ? $_SERVER ['REMOTE_USER'] . '@' : '') . (isset ( $_SERVER ['HTTP_HOST'] ) ? $_SERVER ['HTTP_HOST'] : ($_SERVER ['SERVER_NAME'] . ($https && $_SERVER ['SERVER_PORT'] === 443 || $_SERVER ['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER ['SERVER_PORT']))) . substr ( $_SERVER ['SCRIPT_NAME'], 0, strrpos ( $_SERVER ['SCRIPT_NAME'], '/' ) );
    }  

    //上傳圖片用
    public function _uploadFile($filedata, $path , $uid) {
        $img = explode ( ',', $filedata );
        $data = base64_decode ( $img [1] );

        if (! file_exists ( $path )) {
            mkdir ( $path, 0777, true );
        }

        $filename = uniqid () . '.jpg';


        $success = file_put_contents ( $path . $filename, $data );

        if ($success) {
            $data1['iUserId'] = $uid;
            $data1['vFileType'] = filetype( $path . $filename );
            $data1['vFileServer'] = $this->get_full_url () . "/";
            $data1['vFilePath'] = $path;
            $data1['vFileName'] = $filename;
            $data1['vFileSize'] = filesize( $path . $filename);
            $data1['iCreateTime'] = time();

            $fileid = DB::table('files')->insertGetId($data1);

            return $fileid;
        }else{
            $error = 'error';
            return $error;
        }
    }


    function test () {
    	$name = trim((Input::has ( 'name' )) ? Input::get ( 'name' ) : "");
    	$des = trim((Input::has ( 'des' )) ? Input::get ( 'des' ) : "");
    	$img = trim((Input::has ( 'img' )) ? Input::get ( 'img' ) : "");
    	$number = trim((Input::has ( 'number' )) ? Input::get ( 'number' ) : "");

    	$path = 'upload/shop/';

    	$data ['vName'] = $name;
    	$data ['vDes'] = $des;
    	$data ['iCount'] = $number;
    	$data ['vImage'] = $this->_uploadFile ( Input::get ( 'img' ) , $path , 0);

    	DB::table('shop')->insert($data);

    	$this->rtndata ['status'] = 1;
    	$this->rtndata ['message'] = 'success';
    	return response () -> json ( $this->rtndata );
    }

    function getall () {
    	$all = DB::table('shop')->get();

    	foreach ($all as $key => $value) {
    		$map ['iId'] = $value->vImage;

    		$getUrl = DB::table('files')->where($map)->first();

    		$all[$key]->vImage = $getUrl->vFileServer . $getUrl->vFilePath . $getUrl->vFileName;
    	}

    	$this->rtndata ['status'] = 1;
    	$this->rtndata ['info'] = $all;
    	$this->rtndata ['message'] = 'success';
    	return response () -> json ( $this->rtndata );
    }

    function buy () {
    	$id = trim((Input::has ( 'id' )) ? Input::get ( 'id' ) : "");
    	$count = trim((Input::has ( 'count' )) ? Input::get ( 'count' ) : "");

    	$map ['iId'] = $id;
    	$getShop = DB::table('shop')->where( $map )->first();

    	if( !$getShop ) {
    		$this->rtndata ['status'] = 0;
    		$this->rtndata ['message'] = 'error';
    		return response () -> json ( $this->rtndata );
    	}

    	$data ['iCount'] = $getShop->iCount - $count;

    	DB::table('shop')->where($map)->update($data);

    	$this->rtndata ['status'] = 1;
    	$this->rtndata ['message'] = 'success';
    	return response () -> json ( $this->rtndata );
    }
}
