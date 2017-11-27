<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的收藏</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <script src="/Public/resource/hw/js/vue.lazyimg.js"></script>
    <style>
        .page, .page-group{background: rgb(238,238,238)}
        .hw-list1 ul{list-style: none;margin: 0px;padding: 0px;}
        .hw-list1 ul li{list-style: none;width: 100%;background: #fff;padding:5pt 11.5pt;margin-bottom: 5px; }

        .content-block{margin: 0px;padding: 0px;margin-top: 5px;}
        .clear{clear: both}
        .hlistbody{padding: 5px 0px;position: relative}
        .hlistbody img{width: 76px;height: 76px;float: left}
        .hlistbody .col-80 h3{font-size: 14px;color:rgb(20,20,23);margin: 0px;padding: 0px;font-weight: normal }
        .hlistbody .col-80 span{font-size: 12px;color: rgb(153,153,153)}
        .hlistbody .col-80 b{font-size: 18px;padding: 0px;margin: 0px;font-family: "PingFangSC-Regular";width: 100%;display: block;color: rgb(255,0,67);float: right}
        .hlistbody .col-20{text-align: right;}
        .hlistbody .col-20 span{font-size: 14px;float: right;display: block;width: 100%}
        span.xiajia{font-size: 12px;background: rgb(238,238,238);width: 55px !important;text-align: center;color: rgb(153,153,153);position: absolute;bottom: 10px;right:5px;}
        .xj{color: rgb(153,153,153) !important}
        .nocart{text-align: center}
        .nocart img{margin-top: 90px;}
    </style>
    <script type="text/javascript">
        Vue.use(Vue.lazyimg,{
            fadein: true,
            nohori: false,
            speed: 20
        })
    </script>
</head>
<body>
<div class="page-group">
    <div class="page">
        <div class="content">
            <div class="content-block hw-list1" v-if="data.length>0">
                <ul>
                    <template v-for="(mykey,item) in data">
                    <li>
                        <div class="hlistbody">
                            <img src="/Public/resource/hw/images/grey.gif" v-lazyload:opt.fadein="item.goods['thumbnail']" @click="url(item.goods.status,item.goods['commodityid'])">
                            <div class="row" style="margin-left: 80px">
                                <div class="col-80 " @click="url(item.goods.status,item.goods['commodityid'])">
                                    <h3 class="xj" v-if="item.goods.status == 0">{{ item.goods['title']}}</h3>
                                    <h3 v-else>{{ item.goods['title']}}</h3>
                                    <b class="xj" v-if="item.goods.status == 0">￥{{ item.goods['current']}}</b>
                                    <b v-else>￥{{ item.goods['current']}}</b>
                                </div>
                                <div class="col-20">
                                    <span class="icon icon-remove" @click="del(item.loveid,this)"></span>
                                    <span class="xiajia" v-if="item.goods.status == 0">已下架</span>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </li>
                    </template>
                </ul>
            </div>
            <div class="nocart" v-else>
                <a href="/">
                    <img src="/Public/resource/hw/images/image_qgg.png" width="140">
                </a>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    $(function () {
        $.showIndicator();
        $.post('/Home/love/index.html',function (data) {
            vm.data = $.parseJSON(data);
            $.hideIndicator();
        })
    })
    var vm = new Vue({
        el: 'body',
        data: {
            data : [],
        },
        methods: {
            del: function (id,event) {
                $.confirm('确定要删除吗?', function () {
                    $.showIndicator();
                    $.get('/Home/Love/del/?id='+id,function (data) {
                        $temp = $.parseJSON(data);
                        if($temp['status'] == "200"){
                            vm.data.$remove(vm.data[event.$index])
                        }
                        $.toast($temp['text']);
                        $.hideIndicator();
                    })
                });
            },
            url:function (status,id) {
                if(status == 0){
                    window.location.href = "/Home/goods/detail/?id="+id
                }
            },
        }
    })
</script>
</body>
</html>