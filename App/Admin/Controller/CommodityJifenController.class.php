<?php
namespace Admin\Controller;
use Think\Controller;
class CommodityJifenController extends PublicController {

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('CommodityJifen');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：商品列表
     */
    public function lists(){
        $get = I('get.');
        if($get['type'] == 1){
            $map['title'] = array('like','%'.$get['keyword'].'%');
        }elseif($get['type'] == 2){
            $map['huohao'] = array('like','%'.$get['keyword'].'%');
        }

        $map['shopid'] = $this->shopid;
        $map['type'] = 2;
        $count      = $this->model->where($map)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $this->model->where($map)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：添加商品
     */
    public function add(){
        $carriage = D('carriage')->get_all($this->shopid);//获取运费模版数据
        $guige = D('Specifications')->get_all();//获取该店铺自由的规格
        $classify = D('classify')->get_all($this->shopid);

        $this->assign('classify',$classify);
        $this->assign('guige',$guige);
        $this->assign('carriage',$carriage);
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：添加编辑商品主方法
     */
    public function handle(){
        $data = I('post.');
        if ($this->model->create($data)) {
            $this->model->shopid = $this->shopid;
            $this->model->type = 2;//积分商品
            if(!$data['commodityid']){
                if ($this->model->add() !== false) {
                    retJson("200","添加成功！");
                }else {
                    retJson("404","添加失败！");
                }
            }else{
                if ($this->model->save() !== false) {
                    retJson("200","修改成功！");
                }else {
                    retJson("404","修改失败！");
                }
            }
        }else{
            retJson("404",$this->model->getError());
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：删除指定商品
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
     * 方法功能：编辑某指定商品
     */
    public function edit(){
        $map[$this->pk] = I('get.id',0);
        $carriage = D('carriage')->get_all($this->shopid);//获取运费模版数据
        $commodity = $this->model->where($map)->find();//获取商品数据
        $extend = M('commodity_sku')->where($map)->select();//获取拓展数据
        $guige = D('Specifications')->get_all();//获取该店铺自由的规格
        $classify = D('classify')->get_all($this->shopid);

        $this->assign('classify',$classify);
        $this->assign('commodity',$commodity);
        $this->assign('extend',$extend);
        $this->assign('guige',$guige);
        $this->assign('carriage',$carriage);
        $this->display('add');
    }

}