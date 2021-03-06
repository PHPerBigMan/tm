<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>开始推广</title>
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/hw/css/xiaoshou.css?<?php echo C('CDN_VERSION');?>">
</head>
<body>
<div class="page" style="background: #f4f4f4">
    <div class="row dtop ">
        <div class="col-50">商品</div>
        <div class="col-50" style="text-align: right">佣金</div>
    </div>
    <div class="content infinite-scroll infinite-scroll-bottom">
        <div style="margin-top: 10px;height: 30px"></div>
        <div class="hdbox" v-for="item in data">
            <div class="hdbox2" @click="detail(item.commodityid)">
                <img :src="item.thumbnail" width="50">
                <div class="row no-gutter">
                    <div class="col-50">{{ item.title }}</div>
                    <div class="col-50 tr yongjin">
                        <p>一级佣金：{{ item.firstgraded }}%</p>
                        <p>预计收益：{{ (item.firstgraded*item.current*0.01).toFixed(2) }}元</p>

                        <p>二级佣金：{{ item.secondgraded }}%</p>
                        <p>预计收益：{{ ((item.secondgraded)*item.current*0.01).toFixed(2) }}元</p>

                        <p>三级佣金：{{ item.threegraded }}%</p>
                        <p>预计收益：{{ ((item.threegraded)*item.current*0.01).toFixed(2) }}元</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="infinite-scroll-preloader" v-if=" data.length >=5">
            <div class="preloader"></div>
        </div>
    </div>
</div>
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type="text/javascript" src="<?php echo C('CDN_PATH');?>/Public/resource/assets/js/zepto.qrcode.min.js?<?php echo C('CDN_VERSION');?>"></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    var vm = new Vue({
        el: 'body',
        data: {
            data: <?php echo (json_encode($data)); ?>,
        },
        methods: {
            detail:function (id) {
                window.location.href = "/Home/goods/detail?id="+id
            },
        }
    })
</script>
<script>
    var loading = false;
    // 最多可加载的条目
    var page = 2;
    function addItems() {
        // 生成新条目的HTML
        $.post('/Home/Goods/tglist?page='+page,function (data) {
            console.log(data)
            if(data == "0"){
                $.toast('没有了', 2345, 'success top');
                $.detachInfiniteScroll($('.infinite-scroll'));
                $('.infinite-scroll-preloader').remove();
            }else{
                page++
                vm.data = vm.data.concat(data)
            }
            loading = false;
            $.hideIndicator();
        })
    }

    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {
        console.log(page);
        $.showIndicator();
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