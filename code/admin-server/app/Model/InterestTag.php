<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InterestTag extends Model
{
    protected $table = 'int_tag';
    public $timestamps = false;


    /**
     * [getData 获取基础兴趣标签]
     * @return [type] [description]
     */
    public function getData()
    {
        return $this->where('status_del', 1)->where('parent_code', 'p')->where('user_code', 'A0')->get();
    }

    public function getChildTag($parent_code)
    {
        return $this->where('status_del', 1)->where('parent_code', $parent_code)->get();
    }

    public function getTagName($code)
    {
        return $this->where('code', $code)->select('name')->get();
    }

    public function getTagCode($name)
    {
        return $this->where('name', $name)->select('code')->get();
    }

}
