<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class OrderRefundsModel extends RelationModel {

    protected $_validate = array(

    );

    protected $_map = array(
        
    );

    protected $_auto = array(

    );

    protected $_link = array(
        'order' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'order',
            'foreign_key'  => 'orderid',
            'mapping_fields' => 'uniqueid,money,orderid,type,carriage'
        ),
    );


}