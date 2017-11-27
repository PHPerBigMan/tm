<?php
// +----------------------------------------------------------------------
//            -------------------------
//           /   / ----------------\  \
//          /   /             \  \
//         /   /              /  /
//        /   /    /-------------- /  /
//       /   /    /-------------------\  \
//      /   /                   \  \
//     /   /                     \  \
//    /   /                      /  /
//   /   /      /----------------------- /  /
//  /-----/      /---------------------------/
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://baimifan.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author:黄炜//
//+----------------------------------------------------------------------
namespace Admin\Controller;
use Think\Controller;
class SuggestController extends PublicController{
    /**
     * 合作建议
     */
    protected $model;

    public function _initialize(){
        $this->model = D('Suggest');
    }

    /**
     * 合作建议列表
     */
    public function lists(){
        $count      = $this->model->count();
        $Page       = new \Think\Page($count,8);
        $show       = $Page->show();
        $data = $this->model->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('data',$data);
        $this->assign('page',$show);
        $this->display();
    }

    /**
     * 删除合作建议
     */
    public function del(){
        $map['suggestid'] = I('get.id',0);
        if($this->model->where($map)->delete()){
            retjson("200","删除成功！");
        }else{
            retjson("404","删除失败！");
        }
    }

}