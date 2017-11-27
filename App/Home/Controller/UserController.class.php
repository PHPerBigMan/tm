<?php
namespace Home\Controller;
use Think\Cache\Driver\Hredis;
use Think\Controller;
use Endroid\QrCode\QrCode;
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
        $User = M('user');
        $yiji = $User->where(array('first'=>$this->uid))->field('id,nickname')->select();//获取一级
        $erji = $User->where(array('second'=>$this->uid))->field('id,nickname')->select();//二级
        $sanji = $User->where(array('three'=>$this->uid))->field('id,nickname')->select();//三级
        $temp_user = array($yiji,$erji,$sanji);
        $money = 0;
        foreach ($temp_user as $k => $v){
            foreach ($temp_user[$k] as $k1 => $v1){
                $temp_money = M('dividedinto')->where(array('uid'=>$this->uid,'fromuid'=>$v1['id']))->sum('money');
                if(is_null($temp_money)){
                    $temp_user[$k][$k1]['money'] = 0;
                }else{
                    $temp_user[$k][$k1]['money'] = $temp_money;
                }
                $money = $money + $temp_user[$k][$k1]['money'];
            }
        }
        S('user_money',$money,300);//缓存推广总金额

        $url = D('user')->get_url($this->uid);//获取推广链接

        $this->assign('url',$url);
        $this->assign('data',json_encode($temp_user));
        $this->assign('money',$money);
        $this->display();
    }


    /**
     * 开发者 ： huangwei
     * 方法功能：推广排行榜
     */
    public function paihang(){
        $data = M('user')->limit(0,10)->order('money desc')->field('money,nickname,img')->cache(C('REDIS_KEY').":paihang",300)->select();
        $url = D('user')->get_url($this->uid);//获取推广链接

        $this->assign('url',$url);
        $this->assign('data',$data);
        $this->assign('money',S('user_money'));
        $this->display();
    }

    public function kefu(){
        $id = $_SESSION['user']['id'];
        $data = M('User')->where(["id"=>$id])->field('id,nickname,img')->find();
        $this->assign('data',$data);
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：获取用户返现红包
     */
    public function hongbao(){
        $data = D('Dividedinto')->get_all();
        $money = 0;//初始化
        foreach ($data as $k => $v){
            $money += $v['money'];
        }
        $this->assign('data',array('list'=>$data,'money'=>$money));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：保存用户头像
     * @param $url
     */
    public function save_img($url,$uid){
        $filecontent = downloadweixinfile($url);
        if($filecontent!="404"){
            $filename = "Uploads/img/".$uid.".png";
            saveweixinfile($filename,$filecontent);
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：生成带logo的二维码
     * @param $url
     */
    public function code($url,$id){
        $qrCode = new QrCode();
        $qrCode
            ->setText($url)
            ->setSize(300)
            ->setPadding(0)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setLabelFontSize(16)
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        $logo = 'Uploads/img/'.$id.'.png';//准备好的logo图片
        if ($logo !== FALSE) {
            $QR = $qrCode->getImage();
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        header('Content-Type: image/png');
        imagepng($QR);
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：申请成功推广员
     */
    public function apply(){
        $data = D('user')->get_one($this->uid,array('first'));//获取一级推广用户ID
        if($data['first'] == "0"){
            $temp['nickname'] = "天明眼镜";
        }else{
            $temp = D('user')->get_one($data['first'],array('nickname'));
        }
        $this->assign('name',$temp['nickname']);
        $this->display();
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：申请成推广员主方法
     */
    public function apply_handle(){
        $data = D('user')->get_one($this->uid,array('type','isbuy','first','second','three'));
        if($data['type'] == "1"){
            retJson("404","您应该是推广员，无需重复申请!");
        }

        $save['type'] = 1;
        D('user')->save_one($this->uid,$save);

        retJson("200","申请成功！");
    }

    /**
     * 开发者 ： huangwei
     * 方法功能：生成个人专属推广海报
     */
    public function haibao(){
        $id = I('get.id',0);
        if($id == 0){
            dump("222");
            exit();
        }
        $redis = new Hredis();
        $config = $redis->hmget(C('REDIS_KEY').":config",array('site_name')); //获取配置数据
        $url = D('user')->get_url($id);//获取推广链接
        $user = D('user')->get_one($id,array('nickname','img','id'));
        $this->assign('url',$url);
        $this->assign('user',$user);
        $this->assign('config',$config);
        $this->display();
    }


    /**
     * 开发者 ： huangwei
     * 方法功能：生成个人专属推广海报
     */
    public function haibao3(){
        $id = I('get.id',0);
        if($id == 0){
            dump("222");
            exit();
        }
        $redis = new Hredis();
        $config = $redis->hmget(C('REDIS_KEY').":config",array('site_name')); //获取配置数据
        $url = D('user')->get_url($id);//获取推广链接
        $user = D('user')->get_one($id,array('nickname','img','id'));
        $this->assign('url',$url);
        $this->assign('user',$user);
        $this->assign('config',$config);
        $this->display();
    }


}