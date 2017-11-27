<?php
namespace Api\Model;
use Think\Model;
class UserModel extends Model {

    protected $redis;
    protected $shopid;

    public function __construct($name, $tablePrefix, $connection)
    {
        parent::__construct($name, $tablePrefix, $connection);
        //判断商品推荐集合是否存在，没有则创建集合，并设置过期时间
    }


    protected $_validate = array(

    );

    protected $_map = array(

    );

    protected $_auto = array(

    );

    /**
     * 开发者：huangwei
     * 方法功能：新增用户后,设置session
     * @param $data
     * @param $options
     */
    protected function _after_insert($data, $options){
        session('user',$data);
    }

    /**
     * 开发者：huangwei
     * 方法功能：更新用户积分
     * @param $uid
     * @param $integral
     */
    public function update_integral($uid,$integral){
        $map['id'] = $uid;
        if($this->where($map)->setInc('integral',$integral)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：获取某用户积分值
     * @param $uid
     *
     * @return mixed
     */
    public function get_integral($uid){
        $map['id'] = $uid;
        $integral = $this->where($map)->getField('integral');
        session('user.integral',$integral);
        return $integral;
    }

    /**
     * 开发者：huangwei
     * 方法功能：配置分销数据
     * @param $order  当前订单数据
     */
    public function fenxiao($order){
        $user['id'] = $order['uid'];
        $user_data = $this->where($user)->find();
        if($user_data['isbuy'] == "0"){
            //首次购买记录推荐人
            $map['orderid'] = $order['orderid'];
            $url = M('order_commodity_snop')->where($map)->getField('url');//获取推荐人
            if($url != "0"){
                $url = array_reverse(explode("|",base64_decode($url)));//反序
                $save['isbuy'] = 1;
                $save['first'] = $url[0];
                $save['second'] = $url[1];
                $save['three'] = $url[2];
                $this->where($user)->save($save);
            }
        }
    }

}