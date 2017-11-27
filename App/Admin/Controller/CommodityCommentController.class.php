<?php
namespace Admin\Controller;
use Think\Controller;
class CommodityCommentController extends PublicController {

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('CommodityComment');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：当前店铺所有评价列表
     */
    public function lists(){
        $get = I('get.');
        if($get['id'] != ""){
            $map['commodityid'] = $get['id'];
        }

        $map['shopid'] = $this->shopid;
        $count      = $this->model->where($map)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $this->model->where($map)->relation(true)->order('time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：删除某评价
     */
    public function del(){
        $map[$this->pk] = I('get.id',0);
        if($this->model->where($map)->delete()){
            retJson("200","删除成功！");
        }else{
            retJson("404","删除失败!");
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：店家回复用户评价
     */
    //public function huifu(){
    //    $post = I('post.');
    //    $map['commodity_commentid'] = $post['id'];
    //
    //    if($this->model->where($map)->setField('seller_content',$post['content'])){
    //        retJson("200","回复成功！");
    //    }else{
    //        retJson("404","回复失败！");
    //    }
    //}

}