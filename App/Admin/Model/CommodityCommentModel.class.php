<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class CommodityCommentModel extends RelationModel {

    protected $_validate = array(

    );

    protected $_map = array(
        
    );

    protected $_auto = array(

    );

    protected $_link = array(
        'commodity' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'commodity',
            'foreign_key'  => 'commodityid',
            'mapping_fields' => 'title'
        ),
        'user' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'user',
            'foreign_key'  => 'uid',
            'mapping_fields' => 'nickname,img'
        ),
    );


}