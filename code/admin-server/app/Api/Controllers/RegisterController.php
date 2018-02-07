<?php

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use DB;
use App\User;
use App\Model\UserDetails;
use App\Model\InterestTag;
use App\Api\Controllers\Controller;
date_default_timezone_set('Asia/Shanghai');
class RegisterController extends Controller
{
    /**
     * [register 注册]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function register(Request $request)
    {
        $user_code = 'C'.User::count();
        $school_code = $this->getSchoolCode($request->get('school'));
        $department_code = $this->getDepartmentCode($request->get('department'));
        $this->storeSchoolDepartment($school_code, $department_code);
        $new_user = [
            'name' => $request->get('name'),
            'password' => $request->get('password'),
            'email' => $request->get('email'),
            'code' => $user_code,
        ];
        $dist_user = User::where('name', $new_user['name'])->exists();
        if ($dist_user) {
            return response()->json($this->responseFailed('该用户已存在！'));
        } else {
            $user = User::create($new_user);// 插入新用户
            $user_details = DB::table('user_details')->insert([
                "nickname" => $request->get('nickname'),
                'birth' => $request->get('birthday'),
                'img' => $request->get('img'),
                'sex' => $request->get('sex'),
                'phone' => $request->get('phone'),
                'last_ip' => $this->ip(),
                'last_time' => date('Y-m-d H:m:s'),
                'school_code' => $school_code,
                'department_code' => $department_code,
                'province' => $request->get('school_province'),
                'signlog' => $request->get('signlog'),
                'user_code' => $user_code,
            ]);
    		$data = [
    			'msg' => '注册成功',
    			'url' => 'login'
    		];
        	return response()->json($this->responseData($data));
        }
    }

    /**
     * [getInterestTag 获取兴趣标签]
     * @return [type] [description]
     */
    public function getInterestTag()
    {
        $interest_tag = new InterestTag;
        return response()->json($interest_tag->getData());
    }

}
