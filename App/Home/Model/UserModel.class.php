<?php
namespace Home\Model;
use Think\Cache\Driver\Hredis;
use Think\Model;
class UserModel extends Model {

    protected $redis;
    protected $shopid;

    public function __construct($name, $tablePrefix, $connection)
    {
        parent::__construct($name, $tablePrefix, $connection);
        //判断商品推荐集合是否存在，没有则创建集合，并设置过期时间
        $this->redis = new Hredis();
    }


    protected $_validate = array(

    );

    protected $_map = array(

    );

    protected $_auto = array(

    );

//    /**
//     * 开发者：huangwei
//     * 方法功能：新增用户后,设置session
//     * @param $data
//     * @param $options
//     */
//    protected function _after_insert($data, $options){
//        session('user',$data);
//    }

    /**
     * 开发者：huangwei
     * 方法功能：更新用户积分
     * @param     $uid   用户ID
     * @param     $integral  积分值
     * @param int $type  1为加，2为减
     *
     * @return bool
     */
    public function update_integral($uid,$integral,$type=1){
        $this->get_one($uid);
        $map['id'] = $uid;
        if($type == 1){
            if($this->where($map)->setInc('integral',$integral)){
                $this->redis->HINCRBY(C('REDIS_KEY').":user:".$uid,'integral',$integral);
                return true;
            }else{
                return false;
            }
        }else{
            if($this->where($map)->setDec('integral',$integral)){
                $this->redis->HINCRBY(C('REDIS_KEY').":user:".$uid,'integral',"-".$integral);
                return true;
            }else{
                return false;
            }
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
        $data = $this->get_one($uid,array('integral'));
        return $data['integral'];
    }

    /**
     * 开发者：huangwei
     * 方法功能：获取用户层级关系
     */
    public function get_level($uid){
        $data = M('user')->where(array('id'=>$uid))->field('first,second,three')->find();
        return array_values($data);
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
            $save['isbuy'] = 1;
            $this->where($user)->save($save);
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：UID和opendi的转换
     */
    public function uid_to_openid($uid){
        $data = $this->get_one($uid,array('openid'));
        return $data['openid'];
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：获取某一用户信息
     * 用户ID
     * 返回字段
     */
    public function get_one($id,$return=""){

        $key = C('REDIS_KEY').":user:".$id;

        if(!$this->redis->exists($key)){
            $map['id'] = $id;
            $data = $this->where($map)->find();
            if(!$data){
                return "empty";
            }
            $this->redis->hmset($key,$data);
            $this->redis->expire($key);//设置有效期，默认200秒
            return $data;
        }else{
            if(is_array($return)){
                return $this->redis->hmget($key,$return);
            }else{
                return $this->redis->hGetAll($key);
            }
        }
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：修改某用户数据
     */
    public function save_one($id,$data){
        $key = C('REDIS_KEY').":user:".$id;
        $map['id'] = $id;
        $this->get_one($id);//防止键不存在
        $this->where($map)->save($data);//以后并发量高的话可以做队列处理-------------------------------------预留
        $this->redis->hmset($key,$data);
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：验证用户是否有推广权限
     * $data 用户ID数组
     */
    public function auth($uid,$data){
        if(is_array($uid,$data)){
            return false;
        }

        foreach ($data as $k => $v){
            if($v != 0){
                $temp = $this->get_one($v,array('type'));
                if($temp['type'] == 0 || $temp == "empty"){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：生成推广二维码
     * $id： 用户ID
     */
    public function get_url($id){
        $userdata = $this->get_one($id,array('type','first','second','three'));
        if($userdata['type'] == "1"){
            $level = array_reverse(array($userdata['first'],$userdata['second'],$userdata['three']));//获取用户层级关系
            unset($level[0]);
//            array_push($level,$this->uid);
            array_push($level,$id);
            $url = C('SITE_PATH')."Home/index/index?fromto=".base64_encode(implode("|",$level));//生成分享url
        }else{
            $url = "";//无推广权限
        }

//        return $level;
        return $url;
    }

}