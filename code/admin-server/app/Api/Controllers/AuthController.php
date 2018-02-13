<?php
namespace App\Api\Controllers;

use App\User;
use App\Model\UserDetails;
use App\Model\InterestTag;
use App\Model\IntMoments;
use App\Model\Zan;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use Redirect;
use JWTAuth;
use DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function _initialize()
    {
        $this->cross();
    }
    public function cross()
    {
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:GET,POST,PATCH,PUT,OPTIONS');
    }
    /**
     * [authenticate 登录验证]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('name', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json($this->responsePwdError());
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        // return $credentials;
        $user = new User;
        $user_info = new UserDetails;
        $interest_tag = new InterestTag;
        $user_code = $user->getUserCode($credentials);
        $user = $user_info->userInfo($user_code->code);
        // 翻译兴趣标签
        $int_tag = json_decode($user->ins_code);
        foreach ($int_tag as $key => $value) {
            $name = $interest_tag->getTagName($value);
            $int_tag_name[$value] = $name[0]->name;
        }
        $user->ins_code = $int_tag_name;
        $user->img = json_decode($user->img)[0];
        $user->intdata = $this->getIntData($user_code->code, $user->ins_code);
        return response()->json($this->responseData(compact('token', 'user')));
    }

    //获取当前的用户
    public function getAuthenticatedUser($token)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function getIntData($user_code, $int_code)
    {
        $moment = new IntMoments;
        $zan = new Zan();
        // 根据用户兴趣类型 将信息分类
        $res['全部'] = $this->getIntList('all');
        foreach ($int_code as $k => $v) {
            $res[$v] = $this->getIntList($k);
        }
        return $res;
    }

    /**
     * [getZanNickname 赋赞的用户名]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function getZanNickname($data) {
        $user_details = new UserDetails();
        foreach ($data as $k => $v) {
            $v->name = $user_details->getNickname($v->user_code);
        }
        return $data;
    }

    public function getIntList($int_code)
    {
        $moment = new IntMoments;
        $zan = new Zan();
        $res = array();
        // 根据用户兴趣类型 将信息分类
        $data = $moment->getData('all');
        foreach ($data as $key => $value) {
            if ($value->int_code == $int_code || $int_code == 'all') {
                # code...
                $value->time = $this->getChatTimeStr($value->time);
                // $dis = $zan->disIExists($value->code, $user_code);
                // if($dis) {
                //     $value->dis_zan = false;
                // } else {
                //     $value->dis_zan = true;
                // }
                // $value->comment = $this->sortComments($value->comment);
                $value->imgs = json_decode($value->imgs);
                $value->zan = $this->getZanNickname($value->zan);
                $value->head_img = json_decode($value->userDetails->img);
                // 匹配用户tag
                $res[$key] = $value;
            }
        }
        return $res;


    }

}
