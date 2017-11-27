<?php
namespace Admin\Controller;
use Think\Controller;
use PHPExcel;
class OrderController extends PublicController {

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('Order');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：所有订单列表
     */
    public function lists(){
        $get = I('get.');
        if($get['uid'] != ""){
            $map['uid'] = $get['uid'];
        }

        $start = $get['start'] ? $get['start'] : date('Y-m-01 H:i:s', strtotime(date("Y-m-d")));
        $end = $get['end'] ? $get['end'] : date('Y-m-d H:i:s', strtotime("$start +1 month -1 day -1seconds"));

        if($get['type'] != "2" || $get['type']== null){
            if($get['uniqueid'] != ""){
                $map['uniqueid'] = $get['uniqueid'];
            }else{
                if($get['status'] != "0" && $get['status'] != null){
                    $map['order_state'] = $get['status'];
                }
                $map['create_time'] = array(array('GT',$start),array('lt',$end)) ;
            }
        }

        $map['shopid'] = $this->shopid;
        $count      = $this->model->where($map)->count();
        $Page       = new \Think\Page($count,15);
        $show       = $Page->show();
        $list = $this->model->where($map)->relation(array('snop','user','address'))->limit($Page->firstRow.','.$Page->listRows)->order('create_time desc')->select();
//        $map['order_state'] = array('eq','20');//只获取待发货的订单，其他状态不导出
        S(C('REDIS_KEY').':order_data',$this->model->where($map)->relation(array('snop','user','address'))->order('create_time desc')->select());
        foreach ($list as $k => $v){
            foreach ($list[$k]['snop'] as $k1 => $v1){
                $list[$k]['snop'][$k1]['snopjson'] = json_decode($v1['snopjson'],true);
            }
        }
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->assign('time',array($start,$end));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：修改订单价格
     */
    public function changeorder(){
        $id = I('get.id',0);
        $money = I('get.money',0);
        if($this->model->change_money($id,$money)){
            retJson("200","修改成功！");
        }else{
            retJson("404","修改失败！");
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：取消订单接口
     */
    public function cancelorder(){
        $id = I('get.id',0);
        if($this->model->change_status($id,0)){
            retJson("200","取消订单成功！");
        }else{
            retJson("404","取消订单失败！");
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：订单发货界面
     */
    public function fahuo(){
        $map['orderid'] = I('get.id',0);
        $data = $this->model->where($map)->relation(array('address','extend'))->find();
        $this->assign('data',$data);
        $this->display();
    }
    /**
     * 开发者：huangwei
     * 方法功能：发货主方法
     */
    public function handle(){
        $order_extend = D('order_extend');
        $data = I('post.');
        if($data['express'] == "0"){
            retJson("404","请先选择物流公司！");
        }
        if ($order_extend->create($data)) {
            if(!$data['extendid']){
                $this->model->startTrans();//开启事务
                if ($order_extend->add() !== false) {
                    if($this->model->change_status($data['orderid'],30)){
                        $this->model->commit();//提交数据
                        retJson("200","发货成功！");
                    }else{
                        $error = "发货失败！";
                    }
                }else {
                    $error = "发货失败！";
                }
                $this->model->rollback();//回滚
                retJson("404",$error);
            }else{
                if ($order_extend->save() !== false) {
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
     * 方法功能：查看订单详情
     */
    public function detail(){
        $aid = I('get.aid',0);
        if($aid != 0){
            $map['uniqueid'] = $aid;
        }else{
            $map[$this->pk] = I('get.id',0);
        }
        $data = $this->model->where($map)->relation(true)->find();
        foreach ($data['snop'] as $k1 => $v1){
            $data['snop'][$k1]['snopjson'] = json_decode($v1['snopjson']);
        }
        $this->assign('data',$data);
        $this->display();
    }


    /**
     * 开发者：huangwei
     * 方法功能：导出返现信息
     */
    public function export(){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '订单序号(*)')
            ->setCellValue('B1', '商品名称')
            ->setCellValue('C1', '支付交易号')
            ->setCellValue('D1', '收货人')
            ->setCellValue('E1', '手机号')
            ->setCellValue('F1', '顾客地址（*）')
            ->setCellValue('G1', '付款日期(货到付款时非必填*)')
            ->setCellValue('H1', '商家备注')
            ->setCellValue('I1', '条形码（*）')
            ->setCellValue('J1', '数量（*）')
            ->setCellValue('K1', '付款金额');
        $temp = S(C('REDIS_KEY').':order_data');
//        dump($temp);
//        exit();
        $t = 2;
        foreach ($temp as $k => $v){
            foreach ($temp[$k]['snop'] as $k1 => $v1){
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A'.($t), $k+1)
                    ->setCellValue('B'.($t), json_decode($v1['snopjson'],true)['title'])
                    ->setCellValueExplicit('C'.($t), $v['transaction'], \PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('D'.($t), $v['address']['name'])
                    ->setCellValueExplicit('E'.($t), $v['address']['phone'], \PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('F'.($t), $v['address']['province']." ".$v['address']['city']." ".$v['address']['district']." ".$v['address']['address'])
                    ->setCellValue('G'.($t), date("Y-m-d H:i",strtotime($v['create_time'])))
                    ->setCellValue('H'.($t), '')
                    ->setCellValueExplicit('I'.($t), $temp[$k]['snop'][$k1]['skuid'], \PHPExcel_Cell_DataType::TYPE_STRING)
                    ->setCellValue('J'.($t), $v1['nums'])
                    ->setCellValueExplicit('K'.($t), $v['money'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $t++;
            }
        }
        //
        $objPHPExcel->getActiveSheet()->setTitle('Simple');//设置文件的标题
        $objPHPExcel->setActiveSheetIndex(0);//设置当前工作表
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="01simple.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

}