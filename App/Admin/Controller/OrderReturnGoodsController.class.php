<?php
namespace Admin\Controller;
use Think\Controller;
class OrderReturnGoodsController extends PublicController {

    /**
     * 退货操作
     * @var
     */

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('order_return_goods');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：所有退货申请列表
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
        $list = $this->model->where($map)->relation(true)->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->assign('time',array($start,$end));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：退货详情
     */
    public function detail(){
        $map[$this->pk] = I('get.id',0);
        $data = $this->model->where($map)->relation(true)->find();
        $this->assign('data',$data);
        $this->display();
    }


    /**
     * 开发者：huangwei
     * 方法功能：同意买家退货的申请,设置退货状态为2
     */
    public function agree(){
        $map[$this->pk] = I('get.id',0);

        $data = $this->model->where($map)->field('status,snopid')->find();

        if(is_null($data) || $data['status'] != 1){
            retJson("404","数据异常！");
        }

        if(M('order_commodity_snop')->where(array('snopid'=>$data['snopid']))->setField('is_refunds',2)){
            $this->model->where($map)->setField('status',2);
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

        $data = $this->model->where($map)->field('status,snopid,orderid')->find();
        if(is_null($data) || $data['status'] != 1){
            retJson("404","数据异常！");
        }
        if(M('order_commodity_snop')->where(array('snopid'=>$data['snopid']))->setField('is_refunds',3)){
            $this->model->where($map)->setField('status',3);
            M('order')->where(array('orderid'=>$data['orderid']))->setField('return_status','0');
            retJson("200","操作成功！");
        }else{
            retJson("404","操作失败！");
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：商户确认收货,整个订单设置为已完成状态，收货时间为当前时间.其次对用户积分进行增减，分配关系
     */
    public function shouhuo(){
        $map[$this->pk] = I('get.id',0);

        $data = $this->model->where($map)->field('status,snopid,orderid,money,shopid,uid')->find();
        $order = M('order')->where(array('orderid'=>$data['orderid']))->find();

        if(is_null($data) || $data['status'] != 4){
            retJson("404","数据异常！");
        }
        $this->model->startTrans();
        if($this->model->where($map)->setField('status',5)){
            if(M('order_commodity_snop')->where(array('snopid'=>$data['snopid']))->setField('is_refunds',5)){
                $map2['orderid'] = $data['orderid'];
                $map2['status'] = array('neq',5);
                if(!$this->model->where(array($map2))->find()){//判断是否有商品还在退货中
                    $save['order_state'] = "50";
                    $save['endtime'] = date("Y-m-d H:i:s");
                    $save['refund_amount'] = array('exp','refund_amount+'.$data['money']);//设置订单退款金额
                    $snop = M('order_commodity_snop')->where(array('orderid'=>$data['orderid'],'is_refunds'=>"0"))->select();
                    $integral = 0;//初始化积分值

                    if($order['type'] == "2"){
                        //积分商品，增加用户积分
                        $integral = $order['money'];
                        $t = 1;
                        $money = $order['carriage']*100;
                    }else{
                        //实际商品。计算所获取的积分，并减去
                        foreach ($snop as $k => $v){
                            $snop[$k]['snopjson'] = json_decode($v['snopjson'],true);
                            $integral += round($snop[$k]['snopjson']['integral']*$v['money']*$v['nums']*0.01);
                        }
                        $t = 2;
                        $money = ($order['carriage'] + $order['money'])*100;
                    }


                    if(count($snop) <= 0){//如果不存在未退货的数据
                        $save['evaluation_state'] = "2";
                        $save['is_fencheng'] = "2";
                    }

                    if($integral != 0){
                        //积分值大于0才进入计算,1是加2是减
                        if(!D('Home/user')->update_integral($data['uid'],$integral,$t)){
                            $this->model->rollback();
                            retJson("404","操作失败");
                        }
                    }

                    if(M('order')->where(array('orderid'=>$data['orderid']))->save($save)){//修改订单状态为已完成，并收货
                        A('Home/weixin')->refund($order['transaction'],date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),$money,$money);
                        $this->model->commit();
                        retJson("200","添加成功！");
                    }
                }else{
                    $save['refund_amount'] = array('exp','refund_amount+'.$data['money']);
                    if(!M('order')->where(array('orderid'=>$data['orderid']))->save($save)){
                        $this->model->rollback();
                        retJson("404","操作失败");
                    }
                    $this->model->commit();
                    retJson("200","添加成功！");
                }
            }
        }else{
            retJson("404","操作失败！");
        }
    }

}