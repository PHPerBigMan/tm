<?php
namespace Admin\Controller;
use Think\Controller;
class CommodityController extends PublicController {

    protected $model;
    protected $shopid;
    protected $pk;

    public function _initialize(){
        $this->model = D('Commodity');
        $this->shopid = session('admin.shopid');
        $this->pk = $this->model->getpk();
    }

    /**
     * 开发者：huangwei
     * 方法功能：商品列表
     */
    public function lists(){
        $get = I('get.');
        if($get['type'] == 1){
            $map['title'] = array('like','%'.trim($get['keyword']).'%');
        }elseif($get['type'] == 2){
            $map['huohao'] = array('like','%'.trim($get['keyword']).'%');
        }elseif($get['type'] == 3){
            $classifyid = M('classify')->where(array('name'=>trim($get['keyword'])))->getField('classifyid');
            $map['classifyid'] = $classifyid;
        }

        $map['shopid'] = $this->shopid;
        $map['type'] = 1;
        $count      = $this->model->where($map)->count();
        $Page       = new \Think\Page($count,20);
        $show       = $Page->show();
        $list = $this->model->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('commodityid desc')->select();
        foreach ($list as $k => $v){
            $list[$k]['stock'] = M('commodity_sku')->where(array('commodityid'=>$v['commodityid']))->sum('stock');
        }
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：选择首页商品
     */
    public function lists2(){
        $get = I('get.');
        if($get['type'] == 1){
            $map['title'] = array('like','%'.trim($get['keyword']).'%');
        }elseif($get['type'] == 2){
            $map['huohao'] = array('like','%'.trim($get['keyword']).'%');
        }elseif($get['type'] == 3){
            $classifyid = M('classify')->where(array('name'=>trim($get['keyword'])))->getField('classifyid');
            $map['classifyid'] = $classifyid;
        }

        $map['shopid'] = $this->shopid;
        $map['type'] = 1;
        $count      = $this->model->where($map)->count();
        $Page       = new \Think\Page($count,10);
        $show       = $Page->show();
        $list = $this->model->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('commodityid desc')->select();
        $this->assign('page',$show);
        $this->assign('data',json_encode($list));
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：添加商品
     */
    public function add(){
        $carriage = D('carriage')->get_all($this->shopid);//获取运费模版数据
        $guige = D('Specifications')->get_all();//获取该店铺自由的规格
        $classify = D('classify')->get_all($this->shopid);

        $this->assign('classify',$classify);
        $this->assign('guige',$guige);
        $this->assign('carriage',$carriage);
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：添加编辑商品主方法
     */
    public function handle(){
        $data = I('post.');
//        $ret = upload("800");

//        var_dump($data);die;
        if($data['shuxingji'] == ""){
            retJson("404","商品规格必须上传一个！");
        }
        if ($this->model->create($data)) {
            $this->model->shopid = $this->shopid;
            $this->model->type = 1;

            $post = I('post.');
            $sku = $post['sku_bianma'];
            foreach($sku as $k=>$v){
                if($v != ""){
                    $id = M('commodity_sku')->where(['bianma'=>$v])->getField('commodityid');
                    if(!$data['commodityid']){
                        if(!empty($id)){
                            $status = 404;
                            break;
                        }else{
                            $status = 200;
                            continue;
                        }
                    }else{
                        if((!empty($id) && ($id!=$data['commodityid']))){
                            $status = 404;
                            break;
                        }else{

                            $status = 200;
                            continue;
                        }
                    }
                }else{
                    $status = 200;
                    continue;
                }
            }
            if($status == 200){
                if(!$data['commodityid']){
                    if ($this->model->add() !== false) {

                        retJson("200","添加成功！");
                    }else {
                        retJson("404","添加失败！");
                    }
                }else{
                    if ($this->model->save() !== false) {
                        retJson("200","修改成功！");
                    }else {
                        retJson("404","修改失败！");
                    }
                }
            }else{
                retJson("404","sku编码已存在！");
            }
        }else{
            retJson("404",$this->model->getError());
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：删除指定商品
     */

    public function del(){
        $map[$this->pk] = I('get.id',0);
        if($this->model->where($map)->delete()){
            retJson("200","删除成功！");
        }else{
            retJson("404","删除失败!");
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：编辑某指定商品
     */
    public function edit(){
        $map[$this->pk] = I('get.id',0);
        $carriage = D('carriage')->get_all($this->shopid);//获取运费模版数据
        $commodity = $this->model->where($map)->find();//获取商品数据
        $extend = M('commodity_sku')->where($map)->select();//获取拓展数据
        $guige = D('Specifications')->get_all();//获取该店铺自由的规格
        $classify = D('classify')->get_all($this->shopid);

        $this->assign('classify',$classify);
        $this->assign('commodity',$commodity);
        $this->assign('extend',$extend);
        $this->assign('guige',$guige);
        $this->assign('carriage',$carriage);
        $this->display('add');
    }

    /**
     * 开发者：huangwei
     * 方法功能：商品上下架
     */
    public function remove(){
        $map[$this->pk] = I('get.id',0);
        if(I('get.status') == 0){
            $temp = 1;//上架
        }else{
            $temp = 0;//下架
        }
        if($this->model->where($map)->setField('status',$temp)){
            retJson("200","操作成功！");
        }else{
            retJson("404","操作失败！");
        }

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


    /**
     * 开发者：hongwenyang
     * 方法功能：同步库存  10分钟同步一次  定时任务
     */



    /**
     * @param $product_no
     * @return string
     * 库存代码接口
     */

    public function kc($main){

        if(empty($main)){
            $msg['code'] = 404;
            $msg['msg'] = "请传递正确的商品识别码";
            $data = array();
        }else{
            $count = array();
            if(empty($main)){
                $msg['code'] = 404;
                $msg['msg'] = "商品信息为空";
                $data = array();
            }else{

                $con = mssql_connect();
                if(!$con || !mssql_select_db('dbo',$con)){
                    $msg['code'] = 404;
                    $msg['msg']  = "连接ERP数据库失败";
                    $data = array();
                }else{
                    foreach ($main as $k => $v) {
                        if (!empty($v['bianma'])) {

                            $product_no = $v['bianma'];
                            $product_name = $v['title'];
                            $save[$v['bianma']] = mssql_query("SELECT innumber FROM storage_mst WHERE product_no = $product_no AND Articlename = $product_name");
                        }
                    }
                    foreach ($save as $k => $v) {
                        foreach ($v as $k1 => $v1) {
                            $count[$k] += $v1['innumber'];
                        }
                    }
                    $msg['code'] = 200;
                    $msg['msg'] = "获取数据成功";
                    $data = $count;
                }
            }
        }

        $j = [
            'msg'=>$msg,
            'data'=>$data
        ];

        return json_encode($j);
    }


    public function youhuiquan(){
//        $card_id = "pGklKuMvSxhyCD9ehD8tha8mVcDg";
        $app_id = "wx2932f269a786744a";
        $secret = "37585bfed1f578089c96d2a7a8552ccb";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $app_id . "&secret=" . $secret;
        $code_num = rand(100000000000, 999999999999);
        $access_token = json_decode(file_get_contents($url), true);
        $access_token = $access_token['access_token'];


        $img_url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=".$access_token;
        $data['buffer'] = "@"."./Uploads/logo.jpg";


//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL,$img_url);
//        curl_setopt($ch, CURLOPT_POST, 1 );
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $s1 = curl_exec ($ch);
//
//
//        var_dump(json_decode($s1,true));
//        die;
       $y_url = "https://api.weixin.qq.com/card/create?access_token=".$access_token;
        $time = time();

        $y_info  = "{
    \"card\": {
        \"card_type\": \"MEMBER_CARD\",
        \"member_card\": {
            \"background_pic_url\": \"http://mmbiz.qpic.cn/mmbiz_jpg/UDBB7GV2wSfIZromfEFlBQLjONomDhywAyYaH4TuIXUmozUwDQLj25icKmZOIhRKDcrGCjK1vapPDda6yFheNVQ/0\",
            \"base_info\": {
                \"logo_url\": \"http://mmbiz.qpic.cn/mmbiz_jpg/UDBB7GV2wSfIZromfEFlBQLjONomDhywVSrcJu8kFx0D4mMujM3wUNicoGZIgm2mcPEqyePRr7CeicocMAURW0wA/0\",
                \"brand_name\": \"TianMing\",
                \"code_type\": \"CODE_TYPE_TEXT\",
                \"title\": \"天明眼镜会员卡\",
                \"color\": \"Color101\",
                \"date_info\": {
                    \"type\": \"DATE_TYPE_PERMANENT\"
                },
                \"sku\": {
                    \"quantity\": 50000000
                },
                \"get_limit\": 1,
                \"use_custom_code\": false,
                \"can_give_friend\": false,
                \"custom_url_name\": \"天明微商城\",
                \"custom_url\": \"http://shopceshi.sunday.so/\",
                \"custom_url_sub_title\": \"欢迎进入~\",
                \"promotion_url_name\": \"我的积分\",
                \"promotion_url\": \"http://shopceshi.sunday.so/Home/integral/index/\",
                \"need_push_on_view\": false
            },
           
            \"supply_bonus\": false,
            \"supply_balance\": false,
            \"prerogative\": \"您成为尊为的天明眼镜会员\",
            \"auto_activate\": true
        }
    }
}";
        $re  = $this->curl($y_url,$y_info);
        $time = time();
        $signature = sha1("123".$time."E0o2-at6NcC2OsJiQTlwlFCmTjqI6uE2nG8Yz9drPgbehnMf_kQWuxulGymPLoNmESOVXJO2rN3M-UWatx4EDw"."pGklKuP3QcxmxLWLhr2ULDfT8aPU");
        var_dump($re);die;
       $j_url = "https://api.weixin.qq.com/card/qrcode/create?access_token=".$access_token;
       $j_info = " {
\"action_name\": \"QR_CARD\", 
\"expire_seconds\": 1800,
\"action_info\": {
\"card\": {
\"card_id\": \"pGklKuMssOstjXKUwicQY99Qwjrs\",
\"openid\": \"oFS7Fjl0WsZ9AMZqrI80nbIq8xrA\",
\"is_unique_code\": false ,
\"outer_str\":\"12b\"
  }
 }
}";
       $re = $this->curl($j_url,$j_info);
        var_dump($re);die;
    }
}