<?php
namespace Admin\Controller;
use Think\Controller;
class OrderRefundsController extends PublicController {

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('order_refunds');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：所有退款申请列表
     */
    public function lists(){
        $get = I('get.');

        $start = $get['start'] ? $get['start'] : date('Y-m-01 H:i:s', strtotime(date("Y-m-d")));
        $end = $get['end'] ? $get['end'] : date('Y-m-d H:i:s', strtotime("$start +1 month -1 day -1seconds"));
        if($get['uniqueid'] != ""){
            $map['orderid'] = M('order')->where(array('uniqueid'=>trim($get['uniqueid'])))->getField('orderid');
        }
        $map['time'] = array(array('GT',$start),array('lt',$end)) ;

        $map['shopid'] = $this->shopid;

        $count      = $this->model->where($map)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $this->model->where($map)->relation(true)->limit($Page->firstRow.','.$Page->listRows)->order('time desc')->select();
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->assign('time',array($start,$end));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：同意买家退款的申请,设置订单状态为70退款完成
     */
    public function agree(){
        $map[$this->pk] = I('get.id',0);

        $data = $this->model->where($map)->find();
        $order = M('order')->where(array('orderid'=>$data['orderid']))->find();

        if(is_null($data) || $data['status'] != 1){
            retJson("404","数据异常！");
        }

        if($this->model->where($map)->setField('status',2)){
            if($order['type'] == 2){
                //积分商品加上积分
                M('user')->where(array('id'=>$order['uid']))->setInc('integral',$order['money']);
                $money = $order['carriage']*100;
            }else{
                $money = ($order['money']+$order['carriage'])*100;
            }

            A('Home/weixin')->refund($order['transaction'],date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),$money,$money);
            M('order')->where(array('orderid'=>$data['orderid']))->setField('order_state',70);
            retJson("200","操作成功！");
        }else{
            retJson("404","操作失败！");
        }

    }

    /**
     * 开发者：huangwei
     * 方法功能：拒绝退款申请，订单转为待发货状态
     */
    public function refuse(){
        $map[$this->pk] = I('get.id',0);

        $data = $this->model->where($map)->field('status,orderid')->find();

        if(is_null($data) || $data['status'] != 1){
            retJson("404","数据异常！");
        }

        if($this->model->where($map)->setField('status',3)){
            M('order')->where(array('orderid'=>$data['orderid']))->setField('order_state',20);
            retJson("200","操作成功！");
        }else{
            retJson("404","操作失败！");
        }
    }

}