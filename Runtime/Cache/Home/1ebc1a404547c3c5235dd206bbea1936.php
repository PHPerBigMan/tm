<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>积分商城</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/font/iconfont.css?<?php echo C('CDN_VERSION');?>">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <script src="<?php echo C('CDN_PATH');?>/Public/resource/hw/js/vue.lazyimg.js?<?php echo C('CDN_VERSION');?>"></script>
    <style>
        .bar{background: #fff}
        .bar-tab .tab-item.active, .bar-tab .tab-item:active{color: rgb(255,12,67)}
        .bar-tab .tab-item .icon{font-size: 1rem}
        .allbox ul{padding: 0px;margin: 0px;}
        .allbox ul li{float: left;width: 49%;list-style: none;margin-bottom: 10px;padding: 5px;background: #fff}
        .allbox ul li:nth-child(even){float: right}
        .allbox ul li p{height: 25px;line-height: 25px;display:block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;margin: 0px;font-size: 12px;color: #141417 !important}
        .allbox ul li p b{color: #ff0043;font-size: 14px;}
        .allbox ul li p s{font-size: 14px}
        .allbox ul li img{width: 100%;vertical-align: middle;margin-bottom: 5px}
    </style>
    <script type="text/javascript">
        Vue.use(Vue.lazyimg,{
            fadein: false,
            nohori: false,
            speed: 20
        })
    </script>
</head>
<body>
<div class="page-group">
    <div class="page">
        <div class="content infinite-scroll infinite-scroll-bottom">
            <div class="allbox">
                <ul>
                    <template v-for="(mykey,item) in data">
                        <li>
                            <a href="/Home/goods/detail_jifen/?id={{item.commodityid}}">
                                <img src="/Public/resource/hw/images/grey.gif" v-lazyload:opt.fadein="item.thumbnail">
                                <p>{{ item.title }}</p>
                                <p><b>{{ parseInt(item.current) }}积分</b></p>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
            <div class="infinite-scroll-preloader" v-if=" data.length >=6">
                <div class="preloader"></div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    var loading = false;
    // 最多可加载的条目
    var page = 2;
    function addItems() {
        $.post('/Home/goods/xinpin?page='+page,function (data) {
            if(data == "0"){
                $.toast('没有了', 2345, 'success top');
                $.detachInfiniteScroll($('.infinite-scroll'));
                $('.infinite-scroll-preloader').remove();
            }else{
                page++
                $temp = $.parseJSON(data);
                vm.data = vm.data.concat($temp)
            }
            loading = false;
            $.hideIndicator();
        })
    }
    // 注册'infinite'事件处理函数
    $(document).on('infinite', '.infinite-scroll-bottom',function() {
        $.showIndicator();
        // 如果正在加载，则退出
        if (loading) return;
        // 设置flag
        loading = true;
        addItems();
        $.refreshScroller();
    });
    var vm = new Vue({
        el: 'body',
        data: {
            data : <?php echo (json_encode($data)); ?>,
        },
        methods: {

        }
    })
</script>
</body>
</html>