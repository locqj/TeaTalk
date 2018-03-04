<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use Session;
use App\Model\ServerUsers;
use DB;

class LoginController extends Controller
{
    public function test() {
        return 'ok';
    }
    public function index() {
        return view('welcome');
    }

    public function signin() {
        return view('login.signin');
    }

    public function signout() {
        return view('login.signout');
    }

    public function logout() {
        Session::pull('usercode');
        Session::pull('username');
        return Redirect::to('/');
    }

    /**
     * [signout 提交注册信息]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function signoutUser(Request $request) {
        $server_users = new ServerUsers;
        $count = DB::table('server_users')->count();
        $dist = $server_users->distUser($request->get('name'));
        if (!$dist) {
            $data = DB::table('server_users')->insert([
                'name' => $request->get('name'),
                'pwd' => md5($request->get('pwd').'hzx'),
                'code' => 'hzx'.$count,
                'status_del' => 1,
            ]);
            if ($data) {
                return response()->json($this->responseSuccess("注册成功"));
            } else {
                return response()->json($this->responseFailed("注册失败，网络原因，稍后重试"));
            }
        } else {
            return response()->json($this->responseFailed("账户不可用"));
        }
    }



    /**
     * 辨别用户名是否重复
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function distServerName(Request $request) {
        $server_users = new ServerUsers;
        $dist = $server_users->distUser($request->get('name'));
        if (!$dist) {
            return response()->json($this->responseSuccess("账户可用"));
        } else {
            return response()->json($this->responseFailed("账户不可用"));
        }
    }
    /**
     * 登陆
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doSignin(Request $request) {
        $data = DB::table('server_users')
            ->where('name', $request->get('name'))
            ->where('pwd', md5($request->get('pwd').'hzx'))
            ->first();
        if ($data) {
            Session::put('usercode', $data->code);
            Session::put('username', $data->name);
            return response()->json($this->responseSuccess("登陆成功"));
        } else {
            return response()->json($this->responseFailed("账号密码错误！"));
        }
    }


}
