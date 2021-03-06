<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <link rel="stylesheet" href="/Public/resource/layui/css/layui.css">
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，本系统 暂不支持。 请 <a href="http://browsehappy.com/" target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <small>微信分销商城后台管理系统</small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">
            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> 管理员 <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li><a href="<?php echo U('index/logout');?>"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">
    <!-- sidebar start -->
    <style>
        .admin-parent li span{margin-right: 10px;}
    </style>
    <div class="admin-sidebar am-offcanvas" id="admin-offcanvas" style="overflow: auto">
        <div class="am-offcanvas-bar admin-offcanvas-bar">
            <ul class="am-list admin-sidebar-list">
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-admin'}"><span class="am-icon-user"></span> 管理员管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-admin">
                        <li><a href="<?php echo U('adminGroup/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span> 角色管理</a></li>
                        <li><a href="<?php echo U('admin/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span> 帐号管理</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-site'}"><span class="am-icon-internet-explorer"></span> 网站管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-site">
                        <li><a href="<?php echo U('article/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span> 文章管理</a></li>
                        <li><a href="<?php echo U('carousel/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span> 广告管理</a></li>
                        <li><a href="<?php echo U('suggest/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span> 合作建议</a></li>
                        <li><a href="<?php echo U('Custom/index');?>" target="myiframe"><span class="am-icon-angle-right"></span> 自定义首页</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-user'}"><span class="am-icon-users"></span> 会员管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-user">
                        <li><a href="<?php echo U('user/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>会员管理</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-order'}"><span class="am-icon-desktop"></span> 运营管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-order">
                        <li><a href="<?php echo U('carriage/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>运费模版</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-fanxian'}"><span class="am-icon-file-text-o"></span> 订单管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-fanxian">
                        <li><a href="<?php echo U('order/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>订单列表</a></li>
                        <li><a href="<?php echo U('OrderRefunds/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>退款管理</a></li>
                        <li><a href="<?php echo U('OrderReturnGoods/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>退货管理</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-fenxiao'}"><span class="am-icon-sitemap"></span> 分销管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-fenxiao">
                        <li><a href="<?php echo U('Dividedinto/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>分成记录</a></li>
                        <li><a href="/Admin/Dividedinto/lists2/?status=1" target="myiframe"><span class="am-icon-angle-right"></span>待打款记录</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-goods'}"><span class="am-icon-shopping-bag"></span> 商品管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-goods">
                        <li><a href="<?php echo U('commodity/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>商品列表</a></li>
                        <li><a href="<?php echo U('CommodityJifen/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>积分商品</a></li>
                        <li><a href="<?php echo U('classify/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>分类管理</a></li>
                        <li><a href="<?php echo U('Specifications/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>规格管理</a></li>
                        <li><a href="<?php echo U('CommodityComment/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>评价管理</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-coupon'}"><span class="am-icon-ticket"></span> 优惠管理 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-coupon">
                        <li><a href="<?php echo U('Coupon/lists');?>" target="myiframe"><span class="am-icon-angle-right"></span>优惠券列表</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-sys'}"><span class="am-icon-cog"></span> 系统设置 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-sys">
                        <li><a href="<?php echo U('config/edit');?>" target="myiframe"><span class="am-icon-angle-right"></span>系统设置</a></li>
                        <li><a href="<?php echo U('menu/edit');?>" target="myiframe"><span class="am-icon-angle-right"></span>微信自定义菜单</a></li>
                    </ul>
                </li>
                <li class="admin-parent">
                    <a class="am-cf" data-am-collapse="{target: '#collapse-baobiao'}"><span class="am-icon-bar-chart"></span> 数据报表 <span class="am-icon-angle-right am-fr am-margin-right"></span></a>
                    <ul class="am-list am-collapse admin-sidebar-sub" id="collapse-baobiao">
                        <li><a href="<?php echo U('baobiao/user');?>" target="myiframe"><span class="am-icon-angle-right"></span>会员统计</a></li>
                        <li><a href="<?php echo U('baobiao/money');?>" target="myiframe"><span class="am-icon-angle-right"></span>打款统计</a></li>
                        <li><a href="<?php echo U('baobiao/xiaoshou');?>" target="myiframe"><span class="am-icon-angle-right"></span>销售统计</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- sidebar end -->

    <!-- content start -->
    <div class="admin-content" id="admin-content">
        <div class="admin-content-body">
            <iframe scrolling="yes" frameborder="0" src="<?php echo U('index/welcome');?>" style="width: 100%;height: 100%;position:absolute;padding-right: 185px" name="myiframe"></iframe>
        </div>
    </div>
    <!-- content end -->
</div>

<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu" data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/resource/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/Public/resource/layui/layui.js"></script>
<script>
    layui.use('layim', function(layim){
        layim.config({
            brief: false, //是否简约模式（如果true则不显示主面板）
            isgroup:false,//是否开启群组
            title:"客服",
            isfriend:false,//是否开启好友
            copyright:true,//是否授权
            init: {
                url : '/admin/index/kefu',
                type : 'get',
                data : {}
            }
        });

        var socket  = new WebSocket("ws://"+document.domain+":7277");

        socket.onopen = function(){
            // 登录
            var login_data = JSON.stringify({
                type: 'login',
                id : 999,
                username : "小二",
                avatar : 'http://hcfl.sunday.so/Public/resource/images/timg.jpg'
            });
            socket.send( login_data );
            console.log(login_data)
            console.log("websocket握手成功!");
        };

        //监听收到的消息
        socket.onmessage = function(res){
            var data = eval("("+res.data+")");
            console.log(data);
            switch(data['message_type']){
                // 服务端ping客户端
                case 'ping':
                    socket.send('{"type":"ping"}');
                    break;
                // 登录 更新用户列表
                case 'login':
                    console.log(data['username']+"登录成功");
                    //layim.getMessage(res.data); //res.data即你发送消息传递的数据（阅读：监听发送的消息）
                    break;
                case 'chatMessage':
                    //console.log(data.data);
                    layim.getMessage(data.data);
                    break;
                // 离线消息推送
                case 'logMessage':
                    setTimeout(function(){layim.getMessage(data.data)}, 1000);
                    break;
                // 用户退出 更新用户列表
                case 'logout':
                    break;
                //聊天还有不在线
                case 'ctUserOutline':
                    console.log('11111');
                    //layer.msg('好友不在线', {'time' : 1000});
                    break;

            }
        };

        //layim建立就绪
        layim.on('ready', function(res){
            console.log("sss");
            layim.on('sendMessage', function(res){
                console.log(res);
                // 发送消息
                var mine = JSON.stringify(res.mine);
                var to = JSON.stringify(res.to);
                var login_data = '{"type":"chatMessage","data":{"mine":'+mine+', "to":'+to+'}}';
                socket.send( login_data );
            });
        });

        $('#ssss').on('click', function(){
            layim.chat({
                id: 2,
                name: "正在初始化",
                type: 'friend', //friend、group等字符，如果是group，则创建的是群聊
                avatar: "http://wx.qlogo.cn/mmopen/ajNVdqHZLLDic6l729mhicyhCibnR8eu4SjcrSpM3eXZ4atQnL6aNe5Qlzr2pNJpW8mGuiao1gIROiczROHQ6mCTm4Q/0"
            });
        });
    });
</script>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/Public/resource/assets/js/jquery.min.js"></script>
<!--<![endif]-->
<script src="/Public/resource/assets/js/amazeui.min.js"></script>
<script src="/Public/resource/assets/js/app.js"></script>
</body>
</html>