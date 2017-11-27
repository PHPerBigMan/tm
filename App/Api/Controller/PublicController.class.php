<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {

    /**
     * 开发者：huangwei
     * 方法功能：错误页面
     */
    public function error($text = ''){
        dump($text);
        $this->assign('text',$text);
        $this->display();
    }
}