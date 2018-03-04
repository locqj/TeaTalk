<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServerUsers extends Model
{
    protected $table = 'server_users';
    public $timestamps = false;

    /**
     * 检车用户是否存在
     * @return [type] [description]
     */
    public function distUser($name){
        return $this->where('status_del', 1)->where('name', $name)->exists();
    }

}
