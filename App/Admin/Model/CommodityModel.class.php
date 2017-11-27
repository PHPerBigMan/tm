<?php
namespace Admin\Model;
use Think\Cache\Driver\Hredis;
use Think\Model;
class CommodityModel extends Model {

    public $info;
    protected $redis;
    protected $shopid;

    public function __construct($name, $tablePrefix, $connection)
    {
        parent::__construct($name, $tablePrefix, $connection);
        //判断商品推荐集合是否存在，没有则创建集合，并设置过期时间
        $this->redis = new Hredis();
        $this->shopid = session('admin.shopid');
    }

    /**
     * 开发者：huangwei
     * 方法功能：获取推荐商品集合
     */
    public function get_redis($shopid){
        $key = C('REDIS_KEY').":sx:tuijian:".$shopid;
        if(!$this->redis->exists($key)){
            $map['recommend'] = 2;
            $map['shopid'] = $shopid;
            $data = $this->where($map)->field('commodityid')->select();
            foreach ($data as $k => $v){
                $this->redis->sAdd($key,$v['commodityid']);
            }
            $this->redis->expire($key);//设置有效期，默认200秒
        }
    }

    protected $_validate = array(
        array('huohao','require','货号不能为空！',0,'',3),
        array('huohao','','该货号已经存在！',0,'unique',3),
    );

    protected $_map = array(
        'editorValue' => 'content',
    );

    protected $_auto = array(
        array('thumbnail','setImg',3,'callback'),
        array('carrousel','setLunbo',3,'callback'),
    );

    /**
     * 开发者：huangwei
     * 方法功能：设置缩略图
     */
    protected function setImg(){
        if(!empty(array_filter($_FILES['suolvetu']['name'])) || !empty(array_filter($_FILES['lunbo']['name'])) || !empty(array_filter($_FILES['goodsimg']['name']))  != ""){//上传不为空，则调用上传
            $ret = upload("800");
            if(!is_array($ret)){
                retJson("404",$ret);
            }else{
                $this->info = $ret;
            }
        }

        foreach ($this->info as $k => $v){
            if($v['key'] == "suolvetu"){
                return "/Uploads/".$v['savepath'].$v['savename'];
            }
        }

        return I('post.suo2');//返回已经上传的图
    }

    /**
     * 开发者：huangwei
     * 方法功能：设置轮播图字段
     */
    protected function setLunbo(){
        $temp = array();
        foreach ($this->info as $k => $v){
            if($v['key'] == "lunbo"){
                $temp[] = "/Uploads/".$v['savepath'].$v['savename'];
            }
        }
        if(count($temp) == 0){
            //未上传轮播图
            return json_encode(I('post.xcimg'));
        }else{

            if(I('post.xcimg') == ""){
                return json_encode($temp);
            }else{
                return json_encode(array_merge($temp,I('post.xcimg')));
            }
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：更新拓展表数据
     * @param $data
     * @param $options
     */
    protected function _after_insert($data, $options){
        $post = I('post.');
        foreach ($post['shuxingzhi'] as $k => $v){
            $dataList[] = array(
                'commodityid' => $data['commodityid'],
                'shuxingji'=> htmlspecialchars_decode($post['shuxingji']),
                'attr' => $post['shuxingzhi'][$k],
                'stock' => $post['sku_profit'][$k],
                'attr_money' => $post['sku_price'][$k],
                'bianma' => $post['sku_bianma'][$k],
                'product_no'=>$post['sku_product_no'][$k]
            );
        }

        M('commodity_sku')->addAll($dataList);

        $this->get_redis($this->shopid);//获取推荐商品集合，防止丢失

        $key = C('REDIS_KEY').":tuijian:".$this->shopid;
        //判断商品是否推荐，如果是则写入redis集合
        if($post['recommend'] == "2"){
            $this->redis->sAdd($key,$data['commodityid']);
        }
    }


    protected function _after_update($data, $options){
        $post = I('post.');
        if(count($post['shuxingzhi'])>0){
            $map['commodityid'] = $data['commodityid'];
            M('commodity_sku')->where($map)->delete();
            foreach ($post['shuxingzhi'] as $k => $v){
                $dataList[] = array(
                    'commodityid' => $data['commodityid'],
                    'shuxingji'=> htmlspecialchars_decode($post['shuxingji']),
                    'attr' => $post['shuxingzhi'][$k],
                    'stock' => $post['sku_profit'][$k],
                    'attr_money' => $post['sku_price'][$k],
                    'bianma' => $post['sku_bianma'][$k],
                    'product_no'=>$post['sku_product_no'][$k]
                );
            }

            M('commodity_sku')->addAll($dataList);
        }

        $key = C('REDIS_KEY').":tuijian:".$this->shopid;

        $this->get_redis($this->shopid);//获取推荐商品集合，防止丢失

        //判断商品是否推荐，如果是则写入redis集合
        if($post['recommend'] == "2"){
            $this->redis->sAdd($key,$data['commodityid']);
        }else{
            $this->redis->sRem($key,$data['commodityid']);
        }
    }

}