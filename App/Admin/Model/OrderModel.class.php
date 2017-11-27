<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class OrderModel extends RelationModel {

    protected $_validate = array(

    );

    protected $_map = array(
        
    );

    protected $_auto = array(

    );

    protected $_link = array(
        'snop' => array(
            'mapping_type' => self::HAS_MANY,
            'class_name'   => 'order_commodity_snop',
            'foreign_key'  => 'orderid',
        ),
        'user' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'user',
            'foreign_key'  => 'uid',
            'mapping_fields' => 'nickname,id,img,first,second,three,openid'
        ),
        'address' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'address',
            'foreign_key'  => 'addressid',
        ),
        'extend' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name'   => 'order_extend',
            'foreign_key'  => 'orderid',
            'mapping_fields' => 'express,couriernumber,settime,extendid'
        ),
    );

    /**
     * 开发者：huangwei
     * 方法功能：修改订单价格
     * @param $id    订单ID
     * @param $money 订单价格
     *
     * @return bool  成功返回真
     */
    public function change_money($id,$money){
        $map['orderid'] = $id;
        if($this->where($map)->setField('money',$money)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：修改订单状态
     * @param     $id  订单ID
     * @param int $status  订单状态：0(已取消)10(默认):未付款;20:已付款;30:已发货;40:已收货;
     *
     * @return bool
     */
    public function change_status($id,$status=0){
        $map['orderid'] = $id;
        if($this->where($map)->setField('order_state',$status)){
            return true;
        }else{
            return false;
        }
    }


}