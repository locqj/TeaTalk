<?php

namespace App\Api\Controllers;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use App\Api\Controllers\Controller;
use DB;
use App\User;
use App\Model\IntMoments;
use App\Model\UserDetails;
use App\Model\InterestTag;
date_default_timezone_set('Asia/Shanghai');
class IntMomentsController extends Controller
{
    /**
     * [addMoments 添加朋友圈]
     * @param Request $request [description]
     */
    public function addMoments(Request $request) {
        $int_tag = new InterestTag;
        $moment = [
            'imgs' => $request->get('img'),
            'user_code' => $request->get('user_code'),
            'content' => $request->get('content'),
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'time' => time(),
            'code' => 'IM'.IntMoments::count(),
            'int_code' => $int_tag->getTagCode($request->get('int_tag'))[0]->code
        ];
        $r = IntMoments::insert($moment);
        if ($r) {
            return response()->json($this->responseSuccess("发布成功！"));
        }
    }

    /**
     * [getMoments 获取朋友圈信息]
     * @param  [type] $user_code [description]
     * @return [type]            [description]
     */
    public function getMoments($user_code) {
        $user = new User;
        $user_info = new UserDetails;
        // $user_code = $user->getUserCode($credentials);
        $user = $user_info->userInfo($user_code);
        $data = $this->getIntData($user->ins_code);
        return response()->json($data);
    }

    /**
     * 获取intmoments数据
     * @param  [type] $int_code  [description]
     * @return [type]            [description]
     */
    public function getIntData($int_code)
    {
        $tag = new InterestTag;
        // 根据用户兴趣类型 将信息分类
        $res['全部'] = $this->getIntList('all');
        foreach (json_decode($int_code) as $k => $v) {
            // $res[$v] = $k;
            $tag_name = $tag->getTagName($v)[0]->name;
            $res[$tag_name] = $this->getIntList($v);
        }
        return $res;
    }

    /**
     * 整理intmoments
     * @param  [type] $int_code [description]
     * @return [type]           [description]
     */
    public function getIntList($int_code)
    {
        $moment = new IntMoments;
        $res = array();
        // 根据用户兴趣类型 将信息分类
        $data = $moment->getData($int_code);
        foreach ($data as $key => $value) {
            if ($value->int_code == $int_code || $int_code == 'all') {
                # code...
                $value->time = $this->getChatTimeStr($value->time);
                $value->imgs = json_decode($value->imgs);
                $value->head_img = json_decode($value->userDetails->img);
                // 匹配用户tag
                $res[$key] = $value;
            }
        }
        return $res;
    }



}
