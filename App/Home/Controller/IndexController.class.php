<?php
namespace Home\Controller;
use Think\Cache\Driver\Hredis;
use Think\Controller;
class IndexController extends Controller {

    protected $uid;

    public function  _initialize(){
        $this->uid = session('user.id');
    }

    public function login(){
        session('user',M('user')->where(array('id'=>"1"))->find());
    }

    public function index(){
//        $_SESSION = null;
        session('shopid',1);//固定网站入口页
        $shopid = session('shopid');
//        session('user',M('user')->where(array('id'=>"6"))->find());//电脑模拟登录

        if(is_null($this->uid)){
            redirect('/Home/weixin/login/?url='.urlencode(__SELF__));//跳转到登录
        }

        $redis = new Hredis();
        $get = I('get.');

        $userdata = D('user')->get_one($this->uid,array('isbuy','type','first','second','three','isfix'));
        if($userdata['isfix'] != "1"){
            //未确定关系
            if(!is_null($get['fromto'])){
                $from = explode("|",base64_decode($get['fromto']));
                //此处判断链接有效性，如果有一个链接作弊，全部失效
                if(!D('user')->auth($this->uid,$from)){
                    $save['first'] = 0;
                    $save['second'] = 0;
                    $save['three'] = 0;
                }else{
                    $save['first'] = $from[2];
                    $save['second'] = $from[1];
                    $save['three'] = $from[0];
                }
                $save['isfix'] = 1;
            }else{
                $save['first'] = 0;
                $save['second'] = 0;
                $save['three'] = 0;
                $save['isfix'] = 1;
            }
            D('user')->save_one($this->uid,$save);
        }

        //type为1有推广权限，
        if($userdata['type'] == "1"){
            $level = array_reverse(array($userdata['first'],$userdata['second'],$userdata['three']));//获取用户层级关系
            unset($level[0]);
            array_push($level,$this->uid);
            $url = C('SITE_PATH')."Home/index/index?fromto=".base64_encode(implode("|",$level));//生成分享url
        }else{
            $url = "";//无推广权限
        }

        $carousel = D('Admin/carousel')->get_all($shopid);
        $index = D('custom_page')->get();//获取
        $js = A('weixin')->getjs();//获取微信的分享自定义18个商品
//        echo "<pre>";
//        var_dump($js);die;
        $classify = D('Admin/classify')->get_index_class($shopid);//获取分类，缓存120秒
        $config = $redis->hmget(C('REDIS_KEY').":config",array('site_name','site_logo','notice')); //获取配置数据

        $jsconfig = $js->config(array('onMenuShareAppMessage','onMenuShareTimeline', 'onMenuShareWeibo','getLocation'), false);

        $nowtime=time();

        $list=D('coupon')->where(array('endtime'=>['gt',$nowtime]))->select();

        foreach ($list as $k => $v){
            $is_there =M('cdkey')->where(array('cid'=>$v['id'],'is_issue'=>1,'getuid'=>0))->select();
            if(!empty($is_there)){
                $coupon[] = $v;
            }
//            $is_get=M('cdkey')->where(array('cid'=>$v['id'],'is_issue'=>1,'getuid'=>$this->uid))->select();
//            if( $is_get){
//                $coupons[] = $v;
//            }
//            if($is_get > 0){
//                $this->ajaxReturn(0,"你已经领取过了",0);
//            }
//            dump($is_get);
        }
//        echo "<pre>";
//        var_dump($coupon);die;
//        echo 1;die;
        $phone= 'phone';
        $tel=M('weixin_config')->where(["name"=>$phone])->field('value')->find();
        $this->assign('coupon',$coupon);
        $this->assign('tel',$tel);
        $this->assign('jssdk',$jsconfig);
        $this->assign('config',$config);
        $this->assign('url',$url);
        $this->assign('classify',$classify);
        $this->assign('index',$index);
        $this->assign('carousel',$carousel);
        $this->display();
    }


    public function is_get()
    {
        $cid=I('post.id');
        $nowtime = time();
        $list = M('coupon')->where(array('endtime' => ['gt', $nowtime]))->select();

        foreach ($list as $k => $v) {
            $is_get = M('cdkey')->where(array('cid' => $cid, 'is_issue' => 1, 'getuid' => $this->uid))->select();
        }
        if(empty($is_get)){
            $code = 100;
        }else{
            $code = 200;
        }
        $this->ajaxReturn(json_encode($code));
    }

    public function weixin_kabao()
    {


        $card_id = "pGklKuMvSxhyCD9ehD8tha8mVcDg";
        $app_id = "wx2932f269a786744a";
        $secret = "37585bfed1f578089c96d2a7a8552ccb";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $app_id . "&secret=" . $secret;
        $code_num = rand(100000000000, 999999999999);
        $access_token = json_decode(file_get_contents($url), true);
        $access_token = $access_token['access_token'];


        //导入code码
        $code = "http://api.weixin.qq.com/card/code/deposit?access_token=" . $access_token;
        $code_info = "{
   \"card_id\": \"$card_id\",
   \"code\": [
       \"$code_num\"
   ]
}";

        $this->curl($code, $code_info);
        //核查 code
        $c_code = "http://api.weixin.qq.com/card/code/checkcode?access_token=" . $access_token;
        $c_info = "{
   \"card_id\": \"$card_id\",
   \"code\": [
       \"$code_num\"
   ]
}";
        $c_res = $this->curl($c_code, $c_info);


        //增加库存
        $incres = "https://api.weixin.qq.com/card/modifystock?access_token=" . $access_token;
        $incres_data = "{
            \"card_id\": \"$card_id\",
            \"increase_stock_value\": 1
            }";

        $a = $this->curl($incres, $incres_data);
//        var_dump($incres_info);die;

        /*//设置会员卡积分
        $jifen_url = "https://api.weixin.qq.com/card/membercard/updateuser?access_token=".$access_token;
        $jifen_data = "{
    \"code\": \"$code_num\",
     \"card_id\": \"$card_id\",
    \"bonus\": 100
}";
        $this->curl($jifen_url,$jifen_data);*/


        $url3 = "https://api.weixin.qq.com/card/landingpage/create?access_token=" . $access_token;

        $save_card = "{  
    \"banner\":\"http://mmbiz.qpic.cn/mmbiz_jpg/C2pqtDxbdzE7s0TsUtvSlHR3oGPibxCpBVECgAORg38EuI2FibusiayAe6QaSicvX0vJRtrq2uMxXr23KCDy3QNqzw/0\",
   \"page_title\": \"天明眼镜\",
   \"can_share\": false,
   \"scene\": \"SCENE_NEAR_BY\",
   \"card_list\": [
       {
           \"card_id\": \"$card_id\",
           \"thumb_url\": \"www.qq.com/a.jpg\"
       }
   ]
}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url3);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $save_card);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $s1 = curl_exec($ch);

        $url = json_decode($s1, true);
        $xdata['is_get'] = 1;
        D('User')->where(['id' => session('user.id')])->save($xdata);
        redirect($url['url']);

    }




    public function curl($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $s1 = curl_exec ($ch);

        $data = json_decode($s1,true);
        return $data;
    }


}