<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>个人中心</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/font/iconfont.css?<?php echo C('CDN_VERSION');?>">
    <style>
        .t2{font-size: 18px !important}
        .bar{background: #fff}
        .bar-tab .tab-item.active, .bar-tab .tab-item:active{color: rgb(255,12,67)}
        .bar-tab .tab-item .icon{font-size: 1rem}
        .touxiang{width: 100%;height: 126px;text-align: center;color: #fff;padding: 15px 0px;background: url("<?php echo C('CDN_PATH');?>/Public/resource/images/image_bg.png");background-size: cover;position: relative}
        .tou{width: 66px;height: 66px;border-radius: 50%}
        .tou1{width: 30px;height: 30px;position: absolute;bottom: 40px;left: 50%;margin-left: 10px;}
        .touxiang p{margin: 0px;font-size: 14px;}
        .hw-list{margin-top: 12px !important;margin-bottom: 10px;}
        .hw-list a{color: rgb(20,20,23)}
        .hw-list .item-title{font-size: 14px;}
        .item-content{border-bottom: 1px solid rgb(225,225,225)}
        .zhichi{text-align: center}
        .zhichi img{width: 120px}
        .mylist{background: #fff;margin-bottom: 10px;height: 70px;border-bottom: 1px solid #e7e7e7;padding-top: 10px}
        .mylist p{margin: 0px 0px 10px 15px;padding-top: 5px;font-size: 14px}
        .ddlist .col-20{text-align: center;}
        .ddlist .col-20 a{color: rgb(20,20,23)}
    </style>
</head>
<body>
<div class="page-group">
    <div class="page">
        <nav class="bar bar-tab">
            <a class="tab-item" href="/">
                <span class="iconfont icon-xiao59"></span>
                <span class="tab-label">首页</span>
            </a>
            <a class="tab-item" href="<?php echo U('goods/xinpin');?>">
                <span class="iconfont icon-biaoqian1"></span>
                <span class="tab-label">全部商品</span>
            </a>
            <a class="tab-item" href="<?php echo U('cart/index');?>">
                <span class="iconfont icon-gouwudaib"></span>
                <span class="tab-label">购物车</span>
            </a>
            <a class="tab-item active" href="<?php echo U('center/index');?>">
                <span class="iconfont icon-gerenzhongxin"></span>
                <span class="tab-label">个人中心</span>
            </a>
        </nav>
        <div class="content">
            <div class="touxiang">
                <img src="<?php echo ($_SESSION['user']['img']); ?>" class="tou">
                <?php switch($data["member"]): case "1": ?><img src="<?php echo C('CDN_PATH');?>/Public/resource/images/icon_yinpai.png" class="tou1"><?php break;?>
                    <?php case "2": ?><img src="<?php echo C('CDN_PATH');?>/Public/resource/images/icon_jinpai.png" class="tou1"><?php break;?>
                    <?php case "3": ?><img src="<?php echo C('CDN_PATH');?>/Public/resource/images/icon_zhizun.png" class="tou1"><?php break; endswitch;?>
                <p><?php echo ($_SESSION['user']['nickname']); ?>  ID:<?php echo ($_SESSION['user']['id']); ?></p>
            </div>


            <div class="list-block hw-list">
                <ul>
                    <a href="/Home/order/index/?id=10" class="external">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-dingdan" style="margin-top: -2px"></i></div>
                            <div class="item-inner">
                                <div class="item-title">我的订单</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>
                </ul>
                <div class="mylist">
                    <div class="row no-gutter ddlist" style="margin: 0px 10px">
                        <div class="col-20">
                            <a href="/Home/order/index">
                                <span class="iconfont icon-quanbu"></span>
                                <span class="tab-label">全部</span>
                            </a>
                        </div>
                        <div class="col-20">
                            <a href="/Home/order/index?types=1">
                                <span class="iconfont icon-daifukuan" style="margin-top: -4px;margin-bottom: 4px;"></span>
                                <span class="tab-label">待付款</span>
                            </a>
                        </div>
                        <div class="col-20">
                            <a href="/Home/order/index?types=2">
                                <span class="iconfont icon-cf-c95"></span>
                                <span class="tab-label">待发货</span>
                            </a>
                        </div>
                        <div class="col-20">
                            <a href="/Home/order/index?types=3">
                                <span class="iconfont icon-gonghuoshangshangjiabeihuo"></span>
                                <span class="tab-label">待收货</span>
                            </a>
                        </div>
                        <div class="col-20">
                            <a href="/Home/order/index?types=4">
                                <span class="iconfont icon-daipingjia" style="margin-top: -2px;margin-bottom: 2px"></span>
                                <span class="tab-label">待评价</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>



            <div class="list-block hw-list">
                <ul>

                    <a href="/Home/integral/index/" class="external">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-jifen"></i></div>
                            <div class="item-inner">
                                <div class="item-title">我的积分</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>

                    <a href="/Home/Coupon/index/" class="external">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-hongbao"></i></div>
                            <div class="item-inner">
                                <div class="item-title">我的抵用券</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>

                    <a href="<?php echo U('user/extension');?>">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-rongyu"></i></div>
                            <div class="item-inner">
                                <div class="item-title">推广员中心</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>

                    <a href="<?php echo U('love/index');?>">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-shoucang" style="margin-top: -2px"></i></div>
                            <div class="item-inner">
                                <div class="item-title">我的收藏</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>

                    <a href="<?php echo U('article/guize');?>">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-qingdan"></i></div>
                            <div class="item-inner">
                                <div class="item-title">规则中心</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>

                    <a href="/Home/user/kefu">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-chanpinjianyi"></i></div>
                            <div class="item-inner">
                                <div class="item-title">联系客服</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>
                    <a href="<?php echo U('apply/index');?>">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-jianyi"></i></div>
                            <div class="item-inner">
                                <div class="item-title">合作建议</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>
                    <a href="<?php echo U('address/lists');?>">
                        <li class="item-content">
                            <div class="item-media"><i class="iconfont icon-guanlidizhi"></i></div>
                            <div class="item-inner" style="border-bottom: none">
                                <div class="item-title">收货地址管理</div>
                                <div class="item-after"></div>
                            </div>
                        </li>
                    </a>
                </ul>
            </div>

        </div>
    </div>
</div>
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
</body>
</html>