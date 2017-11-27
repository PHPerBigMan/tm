<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {

    /**
     * 开发者：huangwei
     * 方法功能：错误页面
     */
    public function error($text = ''){
        $this->assign('text',$text);
        $this->display();
    }

    /**
     * 开发者：huangwei
     * 方法功能：获取分类数据
     */
    public function get_classify(){
        $classify = D('Admin/classify')->get_index_class(1);//获取分类，缓存120秒
        return $classify;
    }
}