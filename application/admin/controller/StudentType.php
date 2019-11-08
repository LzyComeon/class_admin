<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\exception\ValidateException;
use app\admin\model\Type as TypeModel;
use app\admin\model\Student as StudentModel;
use think\Log;
use think\Request;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class StudentType extends Backend
{

    /**
     * StudentType模型对象
     * @var \app\admin\model\StudentType
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\StudentType;

    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with(["student", "type"])
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->with(["student", "type"])
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();
            $list = collection($list)->toArray();
            foreach ($list as $key => $item) {
                $list[$key]['student_id'] = $item['student']['name'];
                $list[$key]['type_id'] = $item['type']['type_name'];
                $list[$key]['state'] = $item['state'] ? '减' : '加';
            }
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

    public function add()
    {

        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    if ($params['state'] == 0) {
                        Db::name('Student')->where('id', $params['student_id'])
                            ->update([
                                'cry' => Db::raw('cry+' . $params['put_crys']),
                            ]);
                    } else if ($params['state'] == 1) {
                        Db::name('Student')->where('id', $params['student_id'])
                            ->update([
                                'cry' => Db::raw('cry-' . $params['put_crys']),
                            ]);
                    }

                    $user_info = StudentModel::get($params['student_id']);
                    $params['now_crys'] = $user_info['cry'];
                    $result = $this->model->allowField(true)->save($params);

                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    public static function getTypeByKey($key = 0)
    { //渲染复选框
        $result = (new TypeModel())->where('state', $key)->select();
        return $result;
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
