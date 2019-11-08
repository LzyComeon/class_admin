<?php

namespace app\admin\model;

use think\Model;


class StudentType extends Model
{

    

    

    // 表名
    protected $name = 'student_type';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];



    public function student()
    {
        return $this->belongsTo('Student');

    }

    public function type()
    {
        return $this->belongsTo('Type');

    }







}
