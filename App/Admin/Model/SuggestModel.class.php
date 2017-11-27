<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class SuggestModel extends RelationModel {

    public function __construct($name, $tablePrefix, $connection)
    {
        parent::__construct($name, $tablePrefix, $connection);
    }

    protected $_validate = array(

    );

    protected $_map = array(

    );

    protected $_auto = array(

    );

    protected $_link = array(
        'user' => array(
            'mapping_type' => self::BELONGS_TO,
            'class_name'   => 'user',
            'foreign_key'  => 'uid',
            'mapping_fields' => 'nickname,id,img,first,second,three,openid'
        ),
    );



}