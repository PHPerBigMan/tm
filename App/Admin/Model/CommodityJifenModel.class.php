<?php
namespace Admin\Model;
use Think\Cache\Driver\Hredis;
use Think\Model;
class CommodityJifenModel extends Model {

    public $info;
    protected $redis;
    protected $shopid;
    protected $tableName = 'commodity';

    public function __construct($name, $tablePrefix, $connection)
    {
        parent::__construct($name, $tablePrefix, $connection);
    }

    protected $_validate = array(

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
            $ret = upload();
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
            );
        }

        M('commodity_sku')->addAll($dataList);
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
                );
            }

            M('commodity_sku')->addAll($dataList);
        }
    }

}