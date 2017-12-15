<?php
namespace App\Api\Controllers;

use App\User;
use App\Model\UserDetail;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use Illuminate\Support\Facades\Storage;
use Redirect;
use JWTAuth;
use DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UploadsController extends Controller
{   
     /**
     * [uploadHeadImg 上传]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadHeadImg(Request $request)
    {   
        $filename = array();
        if ($request->isMethod('POST')) {
            foreach ($request->file('photo') as $key => $file) {
                $originalName = $file->getClientOriginalName(); //原文件名
                $ext = $file->getClientOriginalExtension(); //扩展名
                $type = $file->getClientMimeType(); //MimeType
                $realPath = $file->getRealPath(); //临时绝对路径
                $filename[$key] = '/test/storage/'.date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;
                $bool = Storage::disk('public')
                    ->put($filename[$key], file_get_contents($realPath));
            }            
        }
        $req_data = array();
        $req_data['msg'] = '上传成功!';
        $req_data['img'] = json_encode($filename);
        return response()->json($this->responseData($req_data));
    }
}