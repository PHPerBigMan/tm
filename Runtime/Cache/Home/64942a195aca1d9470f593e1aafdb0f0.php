<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>成为分销商</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <script src="http://cdn.bootcss.com/vue/1.0.25/vue.min.js"></script>
    <script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
    <style>
        body{margin: 0px;background: #2d384e}
        .fxbody{width: 100%;height: 100%;text-align: center;position: relative}
        .fxbody img{width:320px}
        .fxname{position: absolute;top: 200px;color: #85BFFF;font-size: 22px;text-align: center;width: 100%}
        .fxbtn{width: 280px;height: 33px;line-height:33px;text-align: center;position: absolute;bottom: 20px;color: #fff;left: 50%;margin-left: -140px;background: rgb(126,211,33);border-radius: 8px}
    </style>
</head>
<body>
<div class="fxbody">
    <img src="/Public/resource/images/tgy.png">
    <div class="fxname"><?php echo ($name); ?></div>
    <div class="fxbtn" @click="tuiguang">成为推广员</div>
</div>
<script>
    var vm  = new Vue({
        el: 'body',
        data: {

        },
        methods: {
            tuiguang: function (event) {
                $.get('/Home/user/apply_handle',function(data){
                    $temp = $.parseJSON(data)
                    if($temp['status'] == "200"){
                        window.location.href = '/Home/user/extension'
                    }else{
                        $.toast($temp['text']);
                    }
                })
            }
        }
    })
</script>
</body>
</html>