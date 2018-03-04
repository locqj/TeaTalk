<?php

namespace App\Api\Controllers;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use App\Api\Controllers\Controller;
use DB;
use App\User;
use App\Model\Moments;
use App\Model\Zan;
use App\Model\UserDetails;
use App\Model\MomentsComment;
date_default_timezone_set('Asia/Shanghai');
class MomentsController extends Controller
{
    public function test ()
    {
        return DB::table('users')->get();
    }



    /**
     * [addMoments 添加朋友圈]
     * @param Request $request [description]
     */
    public function addMoments(Request $request) {
        $moment = [
            'img' => $request->get('img'),
            'user_code' => $request->get('user_code'),
            'content' => $request->get('content'),
            'year' => date('Y'),
            'month' => date('m'),
            'day' => date('d'),
            'time' => time(),
            'code' => 'M'.Moments::count(),
            'sharenear' => $request->get('sharenear'),
            'sharepublic' => $request->get('sharepublic')
        ];
        $r = Moments::insert($moment);
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
        $moment = new Moments();
        $zan = new Zan();
        $data = $moment->getData();
        foreach ($data as $key => $value) {
            $value->time = $this->getChatTimeStr($value->time);

            $dis = $zan->disExists($value->code, $user_code);
            if($dis) {
                $value->dis_zan = false;
            } else {
                $value->dis_zan = true;
            }
            $value->comment = $this->sortComments($value->comment);
            $value->img = json_decode($value->img);
            $value->zan = $this->getZanNickname($value->zan);

        }
        return $data;
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
    /**
     * [sortComments 评论整理]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function sortComments($data) {
        $user_details = new UserDetails();
        foreach ($data as $key => $value) {
            if (substr($value->parent_code, 0, 4) == 'FMC0') {
                $value->status_first = 1;
            } else {
                $value->status_first = 0;
            }
            if ($value->status_del == 0) {
                unset($data[$key]);
            }
            $value->user_name = $user_details->getNickname($value->user_code);
            $value->to_user_name = $user_details->getNickname($value->to_user_code);
            $value->time = $this->getChatTimeStr($value->time);

        }
        return $data;
    }


    /**
     * [doZans 点赞]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doZans(Request $request) {
        $zan = new Zan();
        $dis = $zan->disExists($request->get('moment_code'), $request->get('user_code'));
        if (!$dis) {
            $zan->insert([
                'user_code' => $request->get('user_code'),
                'moment_code' => $request->get('moment_code')
            ]);
            return response()->json($this->responseSuccess("点赞成功！"));
        } else {
            $zan->del($request->get('moment_code'), $request->get('user_code'));
            return response()->json($this->responseSuccess("取消点赞！"));

        }
    }
    /**
     * [doComment 提交评论]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doComment(Request $request) {
        $moment_comment = new MomentsComment();
        $data = [
            'content' => $request->get('content'),
            'user_code' => $request->get('user_code'),
            'to_user_code' => $request->get('to_user_code'),
            'code' => 'MC'.$moment_comment::count(),
            'parent_code' => $request->get('parent_code'),
            'time' => time(),
            'moment_code' => $request->get('moment_code')

        ];
        if ($moment_comment->insert($data)) {
            return response()->json($this->responseSuccess("评论成功"));
        } else {
            return response()->json($this->responseFail("评论失败"));
        }
    }


    public function ownMoments(Request $request) {
        $moments = new Moments;
        $data = $moments->getOwnData($request->get('user_code'));
        return response()->json($data);
    }




}
