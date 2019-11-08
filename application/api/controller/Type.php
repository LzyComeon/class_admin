<?php


namespace app\api\controller;

use app\api\model\Type as TypeModel;
use think\Request;

class Type extends Base
{
    // 根据state获取类型
    public function getTypeByState($state)
    {
       $result =  (new TypeModel())->where('state', $state)->select ();

      parent::success('success', $result, 200, 'json');
    }


}