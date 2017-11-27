<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends PublicController {

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('Article');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：新店铺开通后自动填充文章数据
     */
    public function Fill($id,$title){
        $map['shopid'] = $id;
        $map['title'] = $title;
        $map['content'] = "";
        if($this->model->add($map)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：店铺文章列表
     */
    public function lists(){
        $map['shopid'] = $this->shopid;
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
     * 方法功能：编辑店铺文章内容
     */
    public function edit(){
        $map['shopid'] = $this->shopid;
        $map[$this->pk] = I('get.id',0);
        $data = $this->model->where($map)->find();
        $this->assign('data',$data);
        $this->display('add');
    }

    /**
     * 开发者：huangwei
     * 方法功能：修改文章信息
     */
    public function handle(){
        $data = I('post.');
        if ($this->model->create($data)) {
            if ($this->model->save() !== false) {
                retJson("200","修改成功！");
            }else {
                retJson("404","修改失败！");
            }
        }else{
            retJson("404",$this->model->getError());
        }
    }

}