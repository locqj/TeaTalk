<?php

namespace App\Api\Controllers;


use App\Api\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\Traits\Responder;
use DB;
use App\User;
use App\Model\UserDetails;
use App\Model\School;
use App\Model\Department;
use App\Model\UserManages;
use App\Model\Moments;
date_default_timezone_set('Asia/Shanghai');
class FriendsController extends Controller
{


    /**
     * [getFriends 获取朋友信息 不分组]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getFriends(Request $request) {
        $user_manages = new UserManages();
        $data = $user_manages->getFriends($request->get('own_code'));
        return $data;
    }


    
    /**
     * [getFriendsList 好友通讯录]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getFriendsList(Request $request) {
        $user_manages = new UserManages();
        $data = $user_manages->getFriends($request->get('own_code'));
        $data = $this->doClassifyFriends($data);
        return $this->groupSameKey($data, 'first_word');
    }



    /**
     * [doClassifyFriends 朋友列表数据分类]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function doClassifyFriends($data) {
        $school = new School();
        $department = new Department();
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $value->school_name = $school->getSchoolName($value->wUserDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->wUserDetails->department_code);
                $value->first_word = $this->getFirstCharter($value->wUserDetails->nickname); //获取nickname的第一个字符
                if ($value->aUsers->status_del == 0) {
                    unset($data[$key]);
                }
                $value->head_img = json_decode($value->wUserDetails->img)[0];
            }
        }
        return $data;
    }


    /**
     * [doFindUsers 搜索用户]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doFindUsers(Request $request) {
        $users = new User();
        $school = new School();
        $department = new Department();
        $user_manages = new UserManages();
        $data = $users->getUsers($request->get('talkname'), $request->get('own_code'));
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $value->school_name = $school->getSchoolName($value->userDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->userDetails->department_code);
                $dis = $user_manages->disFirst($request->get('own_code'), $value->code);
                if ($dis) {
                    unset($data[$key]);
                }
                $value->head_img = $value->userDetails->img;
            }

        }
        return $data;
    }

    /**
     * [getFriendDetails 获取用户详情]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getFriendDetails(Request $request) {
        $users = new User();
        $school = new School();
        $department = new Department();
        $user_manages = new UserManages();
        $data = $users->where('code', $request->get('user_code'))->where('status_del', 1)->with('userDetails')->first();
        $data->school_name = $school->getSchoolName($data->userDetails->school_code);
        $data->imgs = $this->getUserPhoto($request->get('user_code'));
        $data->department_name = $department->getDepartmentName($data->userDetails->department_code);
        $data->head_img = json_decode($data->userDetails->img)[0];
        return $data;
    }

    /**
     * [getAccpetUsers 获取等待接受名单]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getWaitAcceptUsers(Request $request) {
        $school = new School();
        $department = new Department();
        $user_manages = new UserManages();
        $data = $user_manages->getWaitAcceptUsers($request->get('user_code'));
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $value->school_name = $school->getSchoolName($value->wUserDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->wUserDetails->department_code);
                $dis = $user_manages->disFirst($request->get('own_code'), $value->code);
                $value->head_img = $value->wUserDetails->img;

            }
        }
        return $data;
    }


    /**
     * [getAccpetUsers 接受者名单]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getAcceptUsers(Request $request) {
        $school = new School();
        $department = new Department();
        $user_manages = new UserManages();
        $data = $user_manages->getAcceptUsers($request->get('friend_code'));
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $value->school_name = $school->getSchoolName($value->aUserDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->aUserDetails->department_code);
                $dis = $user_manages->disFirst($request->get('own_code'), $value->code);
                $value->head_img = $value->aUserDetails->img;

            }
        }
        return $data;
    }

    /**
     * [getLists 朋友添加详情]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getLists(Request $request) {
        $school = new School();
        $department = new Department();
        $user_manages = new UserManages();
        $getFriends = $user_manages->getFriends($request->get('user_code'));
        $getRefuse = $user_manages->getRefuse($request->get('user_code'));
        $getWaitFriends = $user_manages->getAcceptUsers($request->get('user_code'));
        // 等待接受
        if (isset($getWaitFriends)) {
            foreach ($getWaitFriends as $key => $value) {
                $value->school_name = $school->getSchoolName($value->wUserDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->wUserDetails->department_code);
                $dis = $user_manages->disFirst($request->get('user_code'), $value->code);
                $value->head_img = json_decode($value->wUserDetails->img);

            }
        }
        // 已经通过
        if (isset($getFriends)) {
            foreach ($getFriends as $key => $value) {
                $value->school_name = $school->getSchoolName($value->aUserDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->aUserDetails->department_code);
                $dis = $user_manages->disFirst($request->get('user_code'), $value->code);
                $value->head_img = json_decode($value->aUserDetails->img);
            }
        }
        // 拒绝
        if (isset($getRefuse)) {
            foreach ($getRefuse as $key => $value) {
                $value->school_name = $school->getSchoolName($value->aUserDetails->school_code);
                $value->department_name =
                    $department->getDepartmentName($value->aUserDetails->department_code);
                $dis = $user_manages->disFirst($request->get('user_code'), $value->code);
                $value->head_img = json_decode($value->aUserDetails->img);
            }
        }

        return compact('getRefuse', 'getFriends', 'getWaitFriends');

    }



    /**
     * [doAddFriend 提交添加好友]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doAddFriend(Request $request) {
        $user_manages = new UserManages();
        $dis = $user_manages->disData($request->get('user_code'), $request->get('friend_code'));
        if (!$dis) {
            $req = $user_manages->insert(['user_code' => $request->get('user_code'), 'friend_code' => $request->get('friend_code')]);
            if ($req) {
                return response()->json($this->responseSuccess("发送成功！"));
            }
        } else {
            return response()->json($this->responseFailed("已发送！"));
        }
    }

    /**
     * [doAccpetFriend 接受添加好友]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doAcceptFriend(Request $request) {
        $user_manages = new UserManages();
        $req = $user_manages->doUpdate($request->get('friend_code'), $request->get('user_code'), 1);
        if ($req) {
            $dis = $user_manages->disData($request->get('user_code'), $request->get('friend_code'));
            if (!$dis) {
                $req = $user_manages->insert(['user_code' => $request->get('user_code'), 'friend_code' => $request->get('friend_code'), 'status' => 1]);
            } else {
                $req = $user_manages->doUpdate($request->get('user_code'), $request->get('friend_code'), 1);
            }
            return response()->json($this->responseSuccess("发送成功！"));
        }
    }

    /**
     * [doRefuseFriend 拒绝添加好友请求]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function doRefuseFriend(Request $request) {
        $user_manages = new UserManages();
        $req = $user_manages->doUpdate($request->get('friend_code'), $request->get('user_code'), 2);
        if ($req) {
            $dis = $user_manages->disData($request->get('user_code'), $request->get('friend_code'));
            if (!$dis) {
                $req = $user_manages->insert(['user_code' => $request->get('user_code'), 'friend_code' => $request->get('friend_code'), 'status' => 2]);
            } else {
                $req = $user_manages->doUpdate($request->get('user_code'), $request->get('friend_code'), 2);
            }
            return response()->json($this->responseSuccess("发送成功！"));
        }
    }



/**
     * @name php获取中文字符拼音首字母
     * @param $str
     * @return null|string
     * @author 潘军伟<panjunwei@ruiec.cn>
     * @time 2015-09-14 17:58:14
     */
    public function getFirstCharter($str)
    {
        if (empty($str)) {
            return '';
        }
        $fchar = ord($str{0});
        if ($fchar >= ord('A') && $fchar <= ord('z')) return strtoupper($str{0});
        $s1 = iconv('UTF-8', 'gb2312', $str);
        $s2 = iconv('gb2312', 'UTF-8', $s1);
        $s = $s2 == $str ? $s1 : $str;
        $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
        if ($asc >= -20319 && $asc <= -20284) return 'A';
        if ($asc >= -20283 && $asc <= -19776) return 'B';
        if ($asc >= -19775 && $asc <= -19219) return 'C';
        if ($asc >= -19218 && $asc <= -18711) return 'D';
        if ($asc >= -18710 && $asc <= -18527) return 'E';
        if ($asc >= -18526 && $asc <= -18240) return 'F';
        if ($asc >= -18239 && $asc <= -17923) return 'G';
        if ($asc >= -17922 && $asc <= -17418) return 'H';
        if ($asc >= -17417 && $asc <= -16475) return 'J';
        if ($asc >= -16474 && $asc <= -16213) return 'K';
        if ($asc >= -16212 && $asc <= -15641) return 'L';
        if ($asc >= -15640 && $asc <= -15166) return 'M';
        if ($asc >= -15165 && $asc <= -14923) return 'N';
        if ($asc >= -14922 && $asc <= -14915) return 'O';
        if ($asc >= -14914 && $asc <= -14631) return 'P';
        if ($asc >= -14630 && $asc <= -14150) return 'Q';
        if ($asc >= -14149 && $asc <= -14091) return 'R';
        if ($asc >= -14090 && $asc <= -13319) return 'S';
        if ($asc >= -13318 && $asc <= -12839) return 'T';
        if ($asc >= -12838 && $asc <= -12557) return 'W';
        if ($asc >= -12556 && $asc <= -11848) return 'X';
        if ($asc >= -11847 && $asc <= -11056) return 'Y';
        if ($asc >= -11055 && $asc <= -10247) return 'Z';
        return null;
    }


    /**
     * [groupSameKey 按首字母分类]
     * @param  [type] $arr [description]
     * @param  [type] $key [description]
     * @return [type]      [description]
     */
    public function groupSameKey($arr,$key){
        $new_arr = array();
        foreach($arr as $k => $v){
            $new_arr[$v[$key]][] = $v;
        }
        return $new_arr;
    }

    public function getUserPhoto($user_code) {
        $moment = new Moments();
        return $moment->getUserPhoto($user_code);
    }


}
