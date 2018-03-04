<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Moments extends Model
{
    protected $table = 'moments';
    public $timestamps = false;

    /**
     * [getData 获取朋友圈]
     * @return [type] [description]
     */
    public function getData() {
    	return $this->where('status_del', 1)->with('users', 'userDetails', 'zan', 'comment')->orderBy('time','desc')->get();
    }

    public function getOwnData($code) {
        $data = $this->where('status_del', 1)->where('user_code', $code)->with('users', 'userDetails', 'zan', 'comment')->orderBy('time','desc')->get();
        foreach ($data as $key => $value) {
            $value->img = json_decode($value->img);
            $value->img_count = count($value->img);
        }
        return $data;

    }

    public function getUserPhoto($user_code) {
        return $this->where('status_del', 1)
            ->where('user_code', $user_code)->where('img', '<>', "")
            ->orderBy('time', 'desc')->limit(3);
    }


    /**
     * [users 用户表关联]
     * @return [type] [description]
     */
    public function users()
    {
        return $this->hasOne('App\User', 'code', 'user_code');
    }

    /**
     * [userDetails 用户表关联]
     * @return [type] [description]
     */
    public function userDetails()
    {
        return $this->hasOne('App\Model\UserDetails', 'user_code', 'user_code');
    }


    /**
     * [userDetails 用户表关联]
     * @return [type] [description]
     */
    public function zan()
    {
        return $this->hasMany('App\Model\Zan', 'moment_code', 'code');
    }


    /**
     * [userDetails 用户表关联]
     * @return [type] [description]
     */
    public function comment()
    {
        return $this->hasMany('App\Model\MomentsComment', 'moment_code', 'code');
    }


}
