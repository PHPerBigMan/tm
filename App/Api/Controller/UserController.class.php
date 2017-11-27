<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {

    protected $shopid;
    protected $uid;

    public function  _initialize(){
        $this->shopid = session('shopid');
        $this->uid = session('user.id');
    }

    public function index(){
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：我的推广
     */
    public function extension(){
        $map['uid'] = $this->uid;
        $data = D('dividedinto')->where($map)->relation(true)->field('fromuid,level,money')->select();//获取所有推广记录
        $money = 0;//初始化总收益

        $first = $second = $three = [];
        foreach ($data as $k => $v){
            $money = $money + $v['money'];//计算总收益
            if($v['level'] == "1"){
                $first[] = $v;
            }elseif ($v['level'] == "2"){
                $second[] = $v;
            }elseif ($v['level'] == "3"){
                $three[] = $v;
            }
        }

        $first = $this->money_add($first);
        $second = $this->money_add($second);
        $three = $this->money_add($three);

        $url = "http://shop.sunday.so/Home/index/index?fromto=".base64_encode(implode("|",array("0","0",$this->uid)));//生成分享url
        $this->assign('url',$url);
        $this->assign('first',$first);
        $this->assign('second',$second);
        $this->assign('three',$three);
        $this->assign('money',$money);
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：对数据处理
     */
    private function money_add($array){
        $item=array();
        foreach($array as $k=>$v){
            if(!isset($item[$v['fromuid']])){
                $item[$v['fromuid']] = $v;
            }else{
                $item[$v['fromuid']]['money']+=$v['money'];
            }
        }
        return array_values($item);
    }

    /**
     * 开发者：huangwei
     * 方法功能：阿里百川openim帐号注册
     * @param $account
     */
    public function reg($uid,$nickname){
        vendor('taobao.index');
        reg("sanxian".$uid,$nickname);
    }

}