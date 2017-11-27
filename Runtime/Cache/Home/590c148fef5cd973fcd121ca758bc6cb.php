<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>返现红包</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/hw/css/hongbao.css?<?php echo C('CDN_VERSION');?>">
</head>
<body>
<div class="page" style="background: #f4f4f4">
    <div class="hbbox">
        <h1>返现总金额：<b><?php echo ($data["money"]); ?>元</b></h1>
    </div>
    <div class="content infinite-scroll infinite-scroll-bottom" style="margin-top: 135px;">
        <div class="row hbbox2" v-for="item in data.list">
            <div class="col-33">返现红包</div>
            <div class="col-33 tcen">{{ item.money }}元</div>
            <div class="col-33 tcen" v-if="item.status==1">等待返现</div>
            <div class="col-33 tcen" v-if="item.status==2"><font color="green">返现成功</font></div>
        </div>
        <div class="infinite-scroll-preloader" v-if="data.length>=12">
            <div class="preloader"></div>
        </div>
    </div>
</div>
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    var vm = new Vue({
        el: 'body',
        data: {
            data: <?php echo (json_encode($data)); ?>
        }
    })
    var loading = false;
    // 最多可加载的条目
    var page = 2;

    function addItems() {
        // 生成新条目的HTML
        var html = '';
        $.post('/Home/user/hongbao.html?page='+page,function (data) {
            if(data == 0){
                $.toast('没有了', 2345, 'success top');
                $.detachInfiniteScroll($('.infinite-scroll'));
                $('.infinite-scroll-preloader').remove();
            }else{
                page++;
                vm.data = vm.data.concat(data)
            }
            loading = false;
        })
    }
    // 上次加载的序号
    var lastIndex = 20;
    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {
        // 如果正在加载，则退出
        if (loading) return;
        // 设置flag
        loading = true;
        addItems();
        $.refreshScroller();
    });
</script>
</body>
</html>