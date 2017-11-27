<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="//cdn.bootcss.com/jquery/2.0.2/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <style>
        ul{padding: 0px;list-style: none}
        body{overflow-y: auto;font-size: 13px;padding-bottom: 80px}
        .index{width: 320px;height: auto;min-height: 300px;border: 1px solid #555555;margin-left: 50px;margin-top: 30px;background: #eee}
        .index h1{margin-bottom: 0px;}
        .index h1 img{width: 100%}
        .lunbo{width: 100%;height: 60px;background: red;color: #fff;text-align: center;line-height: 60px;}
        .lbox{margin-top: -10px;}
        .lbox ul li{float: left;width: 48%;padding: 8px;background: #fff;margin-right: 10px;margin-bottom: 10px;height: 203px}
        .lbox ul li p{font-size: 12px;height: 25px;  line-height: 25px;  display: block;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;  margin: 0px;color: #141417 !important;}
        .lbox ul li p b{color: #ff0043;  font-size: 14px;  margin-right: 10px;}
        .lbox ul li:nth-child(even){margin-right: 0px;}
        .lbox ul li img{width: 100%}
        .save{position: absolute;left: 400px;top: 80px;}
    </style>
</head>
<body>
<div class="am-alert am-alert-success" data-am-alert style="background: #f9edbe;border: 1px solid #f0c36d;color: #333;font-size: 12px;margin: 10px;">
    <button type="button" class="am-close">&times;</button>
    <p>注意：保存后15分钟后首页生效！</p>
</div>
<div class="index">
    <h1>
        <img src="/Public/resource/images/titlebar.png">
    </h1>

    <template v-for="(key,item) in map">
    <div class="lunbo">
        第{{ key }}个轮播图
    </div>
    <div class="lbox">
        <ul>
            <template v-for="(mkey,mitem) in item">
            <li @click="show(key,mkey)" v-if="mitem.title != ''">
                <img :src="mitem.thumbnail">
                <p>{{ mitem.title }}</p>
                <p><b>￥{{ mitem.current }}</b><s>￥{{ mitem.original }}</s></p>
            </li>
            <li @click="show(key,mkey)" v-else>
                <img src="/Public/resource/images/image_add.png">
            </li>
            </template>
        </ul>
        <div style="clear: both"></div>
    </div>
    </template>
</div>

<div class="save">
    <a type="button" class="am-btn am-btn-primary" @click="save">保存</a>
</div>

<!--[if lt IE 9]>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/resource/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/Public/resource/layer/layer.js"></script>
<script src="/Public/resource/assets/js/amazeui.min.js"></script>
<script src="/Public/resource/assets/js/hw-layer.js"></script>
<script src="/Public/resource/assets/js/app.js"></script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.parse.min.js"> </script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/validate-methods.js"></script>
<script>
    var vm = new Vue({
        el: 'body',
        data: {
            map : <?php echo ($data); ?>,
        },
        methods: {
            show: function (key,mkey) {
                layer.open({
                    type: 2,
                    title: '选择商品',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['1200px', '700px'],
                    content: '/Admin/commodity/lists2/f/'+key+'/f1/'+mkey
                });
            },
            save:function () {
                $.post("/Admin/page/handle",{data:vm.map},function (data) {
                    $temp = $.parseJSON(data)
                    if($temp['status'] == "200"){
                        layer.msg($temp['text'],{icon:1,time:1000})
                    }else{
                        layer.msg($temp['text'],{icon:2,time:1000});
                    }
                })
            }
        }
    })
</script>
</body>
</html>