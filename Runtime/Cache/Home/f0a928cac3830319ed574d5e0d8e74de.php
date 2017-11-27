<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的订单</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <link rel="stylesheet" href="/Public/resource/font/iconfont.css">
</head>
<body>
<div class="page-group">
    <div class="page">
        <style>
            .page, .page-group{background: rgb(238,238,238)}
            .bar{background: #fff}
            .bar-tab .tab-item.active, .bar-tab .tab-item:active{color: rgb(255,12,67)}
            .bar-tab .tab-item .icon{font-size: 1rem}

            a.tab-link{font-size: 14px !important;}
            a.button{margin: 0 .5rem !important;padding: 0px !important;}
            .buttons-tab .button.active{border-color: rgb(255,0,67);color: #000}
            .hw-list{margin: 0px;padding: 0px;}
            .hw-list ul{list-style: none;margin: 0px;padding: 0px;}
            .hw-list ul li{list-style: none;width: 100%;background: #fff;padding:5pt 11.5pt;margin-bottom: 5px; }

            .content-block{margin: 0px;padding: 0px;margin-top: 5px;}
            .fr{float: right}
            .clear{clear: both}
            .htitle{font-size: 14px;line-height: 25px;border-bottom: 1px solid rgb(238,238,238);padding-bottom: 5px;}
            .hlistbody{padding: 5px 0px;border-bottom: 1px solid rgb(238,238,238);margin-top: 5px;padding-top:10px;padding-bottom: 10px;}
            .hlistbody img{width: 76px;height: 76px;float: left}
            .hfooter{margin-top: 10px;padding-bottom: 5px}
            .pingjia,.wuliu{float: right;margin-left: 15px;padding:2px 0px;}
            .pingjia{display: block;border: 1px solid rgb(255,0,67);width: 81px;text-align: center;font-size: 14px;color:#fff;background:rgb(255,0,67) }
            .wuliu{display: block;border: 1px solid rgb(20,20,23);width: 81px;text-align: center;font-size: 14px;color:rgb(20,20,23);}
            .tuihuo{display: block;border: 1px solid rgb(20,20,23);width: 65px;text-align: center;font-size: 12px;color:rgb(20,20,23);float: right;margin-top: 5px;}
            .col-68{width: 68%}
            .col-32{width: 32%}
            .hlistbody .col-68 h3{font-size: 14px;color:rgb(20,20,23);margin: 0px;padding: 0px;font-weight: normal }
            .hlistbody .col-68 span{font-size: 12px;color: rgb(153,153,153)}
            .hlistbody .col-32 b{font-size: 16px;padding: 0px;margin: 0px;font-family: "PingFangSC-Regular";width: 100%;display: block;color: rgb(255,0,67);float: right}
            .hlistbody .col-32{text-align: right}
            .hc{color: rgb(255,148,30)}
            .hlistbody .col-32 span{font-size: 14px;float: right;display: block;width: 100%}
            .tuihuo2{font-size: 12px;color:rgb(20,20,23);}
            .nocart{text-align: center}
            .nocart img{margin-top: 90px;}
            .buttons-tab .button{height: 3rem}
        </style>
        <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
        <div class="content">
            <!--<div class="buttons-tab">-->
            <!--<a href="#tab1" class="tab-link active button">全部</a>-->
            <!--<a href="#tab2" class="tab-link button">待付款</a>-->
            <!--<a href="#tab3" class="tab-link button">待发货</a>-->
            <!--<a href="#tab4" class="tab-link button">待收货</a>-->
            <!--<a href="#tab5" class="tab-link button">待评价</a>-->
            <!--</div>-->
            <div class="buttons-tab">
                <a href="#tab1" class="tab-link button <?php if($_GET['types']== 0 ): ?>active<?php endif; ?>">
                    <span class="iconfont icon-quanbu"></span>
                    <span class="tab-label">全部</span>
                </a>
                <a href="#tab2" class="tab-link button <?php if($_GET['types']== 1 ): ?>active<?php endif; ?>">
                    <span class="iconfont icon-daifukuan"></span>
                    <span class="tab-label">待付款</span>
                </a>
                <a href="#tab3" class="tab-link button <?php if($_GET['types']== 2 ): ?>active<?php endif; ?>">
                    <span class="iconfont icon-cf-c95"></span>
                    <span class="tab-label">待发货</span>
                </a>
                <a href="#tab4" class="tab-link button <?php if($_GET['types']== 3 ): ?>active<?php endif; ?>">
                    <span class="iconfont icon-gonghuoshangshangjiabeihuo"></span>
                    <span class="tab-label">待收货</span>
                </a>
                <a href="#tab5" class="tab-link button <?php if($_GET['types']== 4 ): ?>active<?php endif; ?>">
                    <span class="iconfont icon-daipingjia"></span>
                    <span class="tab-label">待评价</span>
                </a>
            </div>
            <div class="content-block">
                <div class="tabs">
                    <div id="tab1" class="tab  <?php if($_GET['types']== 0 ): ?>active<?php endif; ?>">
                        <div class="content-block hw-list" v-if="data.length>0">
                            <ul>
                                <template v-for="(mykey,item) in data">
                                    <li>
                                        <div class="htitle">
                                            <span>订单号：{{ item.uniqueid }}</span>
                                            <span class="fr hc" v-if="item.order_state == 0">已取消</span>
                                            <span class="fr hc" v-if="item.order_state == 10">待付款</span>
                                            <span class="fr hc" v-if="item.order_state == 20">待发货</span>
                                            <span class="fr hc" v-if="item.order_state == 30">待收货</span>
                                            <span class="fr hc" v-if="item.order_state == 50">已完成</span>
                                            <span class="fr hc" v-if="item.order_state == 60">退款中</span>
                                            <span class="fr hc" v-if="item.order_state == 70">退款完成</span>
                                        </div>
                                        <template v-for="(snopkey,snop) in item.snop">
                                            <div class="hlistbody">
                                                <img :src="snop.snopjson['thumbnail']">
                                                <div class="row" style="margin-left: 85px">
                                                    <div class="col-68" @click="godetail(snop.snopjson['commodityid'],item.type)">
                                                        <h3>{{ snop.snopjson['title'] }}</h3>
                                                        <span>{{ snop.attr }}</span>
                                                    </div>
                                                    <div class="col-32">
                                                        <b v-if="snop.snopjson['type'] == 1">￥{{ snop.money }}</b>
                                                        <b v-else>{{ parseInt(snop.money / snop.nums) }}积分</b>
                                                        <span>x{{ snop.nums }}</span>
                                                        <a href="/Home/OrderReturnGoods/index/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 0">申请退货</a>
                                                        <a class="tuihuo2" v-if="item.order_state == 30 && snop.is_refunds == 1">审核中</a>
                                                        <a href="/Home/OrderReturnGoods/wuliu/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 2">商品回寄</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 4">等待卖家收货</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 5">退货成功</a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </template>
                                        <div class="hfooter">
                                            <a href="/Home/order/evaluate/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 50 && item.evaluation_state == 0">评价</a>
                                            <a href="/Home/order/jiesuan/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 10">付款</a>
                                            <a class="wuliu" @click="quxiao(item.orderid,mykey,this)" v-if="item.order_state == 10">取消订单</a>
                                            <a class="wuliu" @click="tuikuan(item.orderid,mykey,this)" v-if="item.order_state == 20">申请退款</a>
                                            <a class="pingjia" v-if="item.order_state == 30 && item.return_status == 0" @click="shouhuo(item.orderid,mykey,2,this)">确认收货</a>
                                            <a href="/Home/order/wuliu/?id={{ item.orderid }}" class="wuliu" v-if="item.order_state == 50 || item.order_state == 30">查看物流</a>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="nocart" v-else>
                            <a href="/">
                                <img src="/Public/resource/hw/images/image_zwtu.png" width="120">
                            </a>
                        </div>
                    </div>
                    <div id="tab2" class="tab <?php if($_GET['types']== 1 ): ?>active<?php endif; ?>">
                        <div class="content-block hw-list" v-if="temp[0].length>0">
                            <ul>
                                <template v-for="(mykey,item) in temp[0]">
                                    <li>
                                        <div class="htitle">
                                            <span>订单号：{{ item.uniqueid }}</span>
                                            <span class="fr hc" v-if="item.order_state == 0">已取消</span>
                                            <span class="fr hc" v-if="item.order_state == 10">待付款</span>
                                            <span class="fr hc" v-if="item.order_state == 20">待发货</span>
                                            <span class="fr hc" v-if="item.order_state == 30">待收货</span>
                                            <span class="fr hc" v-if="item.order_state == 50">已完成</span>
                                            <span class="fr hc" v-if="item.order_state == 60">退款中</span>
                                            <span class="fr hc" v-if="item.order_state == 70">退款完成</span>
                                        </div>
                                        <template v-for="(snopkey,snop) in item.snop">
                                            <div class="hlistbody">
                                                <img :src="snop.snopjson['thumbnail']">
                                                <div class="row" style="margin-left: 85px">
                                                    <div class="col-68" @click="godetail(snop.snopjson['commodityid'],item.type)">
                                                        <h3>{{ snop.snopjson['title'] }}</h3>
                                                        <span>{{ snop.attr }}</span>
                                                    </div>
                                                    <div class="col-32">
                                                        <b v-if="snop.snopjson['type'] == 1">￥{{ snop.money }}</b>
                                                        <b v-else>{{ parseInt(snop.money / snop.nums) }}积分</b>
                                                        <span>x{{ snop.nums }}</span>
                                                        <a href="/Home/OrderReturnGoods/index/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 0">申请退货</a>
                                                        <a class="tuihuo2" v-if="item.order_state == 30 && snop.is_refunds == 1">审核中</a>
                                                        <a href="/Home/OrderReturnGoods/wuliu/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 2">商品回寄</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 4">等待卖家收货</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 5">退货成功</a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </template>
                                        <div class="hfooter">
                                            <a href="/Home/order/evaluate/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 50 && item.evaluation_state == 0">评价</a>
                                            <a href="/Home/order/jiesuan/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 10">付款</a>
                                            <a class="wuliu" @click="quxiao(item.orderid,mykey,this)" v-if="item.order_state == 10">取消订单</a>
                                            <a class="wuliu" @click="tuikuan(item.orderid,mykey,this)" v-if="item.order_state == 20">申请退款</a>
                                            <a class="pingjia" v-if="item.order_state == 30 && item.return_status == 0" @click="shouhuo(item.orderid,mykey,this)">确认收货</a>
                                            <a href="/Home/order/wuliu/?id={{ item.orderid }}" class="wuliu" v-if="item.order_state == 50 || item.order_state == 30">查看物流</a>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="nocart" v-else>
                            <a href="/">
                                <img src="/Public/resource/hw/images/image_zwtu.png" width="120">
                            </a>
                        </div>
                    </div>
                    <div id="tab3" class="tab <?php if($_GET['types']== 2 ): ?>active<?php endif; ?>">
                        <div class="content-block hw-list" v-if="temp[1].length>0">
                            <ul>
                                <template v-for="(mykey,item) in temp[1]">
                                    <li>
                                        <div class="htitle">
                                            <span>订单号：{{ item.uniqueid }}</span>
                                            <span class="fr hc" v-if="item.order_state == 0">已取消</span>
                                            <span class="fr hc" v-if="item.order_state == 10">待付款</span>
                                            <span class="fr hc" v-if="item.order_state == 20">待发货</span>
                                            <span class="fr hc" v-if="item.order_state == 30">待收货</span>
                                            <span class="fr hc" v-if="item.order_state == 50">已完成</span>
                                            <span class="fr hc" v-if="item.order_state == 60">退款中</span>
                                            <span class="fr hc" v-if="item.order_state == 70">退款完成</span>
                                        </div>
                                        <template v-for="(snopkey,snop) in item.snop">
                                            <div class="hlistbody">
                                                <img :src="snop.snopjson['thumbnail']">
                                                <div class="row" style="margin-left: 85px">
                                                    <div class="col-68" @click="godetail(snop.snopjson['commodityid'],item.type)">
                                                        <h3>{{ snop.snopjson['title'] }}</h3>
                                                        <span>{{ snop.attr }}</span>
                                                    </div>
                                                    <div class="col-32">
                                                        <b v-if="snop.snopjson['type'] == 1">￥{{ snop.money }}</b>
                                                        <b v-else>{{ parseInt(snop.money / snop.nums) }}积分</b>
                                                        <span>x{{ snop.nums }}</span>
                                                        <a href="/Home/OrderReturnGoods/index/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 0">申请退货</a>
                                                        <a class="tuihuo2" v-if="item.order_state == 30 && snop.is_refunds == 1">审核中</a>
                                                        <a href="/Home/OrderReturnGoods/wuliu/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 2">商品回寄</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 4">等待卖家收货</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 5">退货成功</a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </template>
                                        <div class="hfooter">
                                            <a href="/Home/order/evaluate/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 50 && item.evaluation_state == 0">评价</a>
                                            <a href="/Home/order/jiesuan/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 10">付款</a>
                                            <a class="wuliu" @click="quxiao(item.orderid,mykey,this)" v-if="item.order_state == 10">取消订单</a>
                                            <a class="wuliu" @click="tuikuan(item.orderid,mykey,this)" v-if="item.order_state == 20">申请退款</a>
                                            <a class="pingjia" v-if="item.order_state == 30 && item.return_status == 0" @click="shouhuo(item.orderid,mykey,this)">确认收货</a>
                                            <a href="/Home/order/wuliu/?id={{ item.orderid }}" class="wuliu" v-if="item.order_state == 50 || item.order_state == 30">查看物流</a>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="nocart" v-else>
                            <a href="/">
                                <img src="/Public/resource/hw/images/image_zwtu.png" width="120">
                            </a>
                        </div>
                    </div>
                    <div id="tab4" class="tab <?php if($_GET['types']== 3 ): ?>active<?php endif; ?>">
                        <div class="content-block hw-list" v-if="temp[2].length>0">
                            <ul>
                                <template v-for="(mykey,item) in temp[2]">
                                    <li>
                                        <div class="htitle">
                                            <span>订单号：{{ item.uniqueid }}</span>
                                            <span class="fr hc" v-if="item.order_state == 0">已取消</span>
                                            <span class="fr hc" v-if="item.order_state == 10">待付款</span>
                                            <span class="fr hc" v-if="item.order_state == 20">待发货</span>
                                            <span class="fr hc" v-if="item.order_state == 30">待收货</span>
                                            <span class="fr hc" v-if="item.order_state == 50">已完成</span>
                                            <span class="fr hc" v-if="item.order_state == 60">退款中</span>
                                            <span class="fr hc" v-if="item.order_state == 70">退款完成</span>
                                        </div>
                                        <template v-for="(snopkey,snop) in item.snop">
                                            <div class="hlistbody">
                                                <img :src="snop.snopjson['thumbnail']">
                                                <div class="row" style="margin-left: 85px">
                                                    <div class="col-68" @click="godetail(snop.snopjson['commodityid'],item.type)">
                                                        <h3>{{ snop.snopjson['title'] }}</h3>
                                                        <span>{{ snop.attr }}</span>
                                                    </div>
                                                    <div class="col-32">
                                                        <b v-if="snop.snopjson['type'] == 1">￥{{ snop.money }}</b>
                                                        <b v-else>{{ parseInt(snop.money / snop.nums) }}积分</b>
                                                        <span>x{{ snop.nums }}</span>
                                                        <a href="/Home/OrderReturnGoods/index/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 0">申请退货</a>
                                                        <a class="tuihuo2" v-if="item.order_state == 30 && snop.is_refunds == 1">审核中</a>
                                                        <a href="/Home/OrderReturnGoods/wuliu/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 2">商品回寄</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 4">等待卖家收货</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 5">退货成功</a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </template>
                                        <div class="hfooter">
                                            <a href="/Home/order/evaluate/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 50 && item.evaluation_state == 0">评价</a>
                                            <a href="/Home/order/jiesuan/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 10">付款</a>
                                            <a class="wuliu" @click="quxiao(item.orderid,mykey,this)" v-if="item.order_state == 10">取消订单</a>
                                            <a class="wuliu" @click="tuikuan(item.orderid,mykey,this)" v-if="item.order_state == 20">申请退款</a>
                                            <a class="pingjia" v-if="item.order_state == 30 && item.return_status == 0" @click="shouhuo(item.orderid,mykey,2,this)">确认收货</a>
                                            <a href="/Home/order/wuliu/?id={{ item.orderid }}" class="wuliu" v-if="item.order_state == 50 || item.order_state == 30">查看物流</a>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="nocart" v-else>
                            <a href="/">
                                <img src="/Public/resource/hw/images/image_zwtu.png" width="120">
                            </a>
                        </div>
                    </div>
                    <div id="tab5" class="tab <?php if($_GET['types']== 4 ): ?>active<?php endif; ?>">
                        <div class="content-block hw-list" v-if="temp[3].length>0">
                            <ul>
                                <template v-for="(mykey,item) in temp[3]">
                                    <li>
                                        <div class="htitle">
                                            <span>订单号：{{ item.uniqueid }}</span>
                                            <span class="fr hc" v-if="item.order_state == 0">已取消</span>
                                            <span class="fr hc" v-if="item.order_state == 10">待付款</span>
                                            <span class="fr hc" v-if="item.order_state == 20">待发货</span>
                                            <span class="fr hc" v-if="item.order_state == 30">待收货</span>
                                            <span class="fr hc" v-if="item.order_state == 50">已完成</span>
                                            <span class="fr hc" v-if="item.order_state == 60">退款中</span>
                                            <span class="fr hc" v-if="item.order_state == 70">退款完成</span>
                                        </div>
                                        <template v-for="(snopkey,snop) in item.snop">
                                            <div class="hlistbody">
                                                <img :src="snop.snopjson['thumbnail']">
                                                <div class="row" style="margin-left: 85px">
                                                    <div class="col-68" @click="godetail(snop.snopjson['commodityid'],item.type)">
                                                        <h3>{{ snop.snopjson['title'] }}</h3>
                                                        <span>{{ snop.attr }}</span>
                                                    </div>
                                                    <div class="col-32">
                                                        <b v-if="snop.snopjson['type'] == 1">￥{{ snop.money }}</b>
                                                        <b v-else>{{ parseInt(snop.money / snop.nums) }}积分</b>
                                                        <span>x{{ snop.nums }}</span>
                                                        <a href="/Home/OrderReturnGoods/index/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 0">申请退货</a>
                                                        <a class="tuihuo2" v-if="item.order_state == 30 && snop.is_refunds == 1">审核中</a>
                                                        <a href="/Home/OrderReturnGoods/wuliu/?id={{ snop.snopid }}" class="tuihuo" v-if="item.order_state == 30 && snop.is_refunds == 2">商品回寄</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 4">等待卖家收货</a>
                                                        <a class="tuihuo2" v-if="snop.is_refunds == 5">退货成功</a>
                                                    </div>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        </template>
                                        <div class="hfooter">
                                            <a href="/Home/order/evaluate/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 50 && item.evaluation_state == 0 && item.snop[0].snopjson['type'] == 1">评价</a>
                                            <a href="/Home/order/jiesuan/?id={{ item.orderid }}" class="pingjia" v-if="item.order_state == 10">付款</a>
                                            <a class="wuliu" @click="quxiao(item.orderid,mykey,this)" v-if="item.order_state == 10">取消订单</a>
                                            <a class="wuliu" @click="tuikuan(item.orderid,mykey,this)" v-if="item.order_state == 20">申请退款</a>
                                            <a class="pingjia" v-if="item.order_state == 30 && item.return_status == 0" @click="shouhuo(item.orderid,mykey,this)">确认收货</a>
                                            <a href="/Home/order/wuliu/?id={{ item.orderid }}" class="wuliu" v-if="item.order_state == 50 || item.order_state == 30">查看物流</a>
                                            <div class="clear"></div>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </div>
                        <div class="nocart" v-else>
                            <a href="/">
                                <img src="/Public/resource/hw/images/image_zwtu.png" width="120">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var vm = new Vue({
                el: 'body',
                data: {
                    data: <?php echo (json_encode($data)); ?>,
                    temp: <?php echo (json_encode($temp)); ?>
                },
                methods: {
                    quxiao: function (id,key,event) {
                        $.confirm('确定要取消该订单吗？', function () {
                            $.get('/Home/Order/cancle/?id='+id,function(data){
                                $temp = $.parseJSON(data)
                                if($temp['status'] == "200"){
                                    vm.data[key]['order_state'] = 0
                                }
                                $.toast($temp['text']);
                            })
                        });
                    },
                    tuikuan: function (id,key,event) {
                        $.confirm('确定要申请退款吗？', function () {
                            $.get('/Home/Order/refund/?id='+id,function(data){
                                $temp = $.parseJSON(data)
                                if($temp['status'] == "200"){
                                    vm.data[key]['order_state'] = 60
                                }
                                $.toast($temp['text']);
                            })
                        });
                    },
                    shouhuo: function (id,key,ikey,event) {
                        $.confirm('确定已经收到货物了？', function () {
                            $.showIndicator()
                            $.get('/Home/Order/Goods_receipt/?id='+id,function(data){
                                $temp = $.parseJSON(data)
                                if($temp['status'] == "200"){
                                    vm.data[key]['order_state'] = 50
                                }
                                $.toast($temp['text']);
                                $.hideIndicator()
                            })
                        });
                    },
                    godetail:function(id){
                        window.location.href = '/Home/goods/detail/?id='+id
                    }
                }
            })
        </script>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PAHT');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PAHT');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
</body>
</html>