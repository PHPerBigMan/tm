<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>我的抵用券</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
</head>
<body>
<div class="page-group">
    <div class="page">
        <style>
            .content1{
                background-color: #fff;
                height:100%;
            }
            .row{background: #fff;color:#000;}
            .hnav .col-50{margin-left: 0px !important;width: 50% !important}
            .hnav{text-align: center;height: 44px;line-height: 44px;font-size: 16px;}
            .wydh{background: rgb(255,12,67);color:#fff;}
            .content{background: #fff;}
            .hnav{box-shadow:0.05rem .1rem rgba(0,0,0,.3);-webkit-tap-highlight-color: transparent;}
            .text{margin:40px 25px;}
            .text input{
                width:100%;
                padding:3px 5px 0px;
                line-height:40px;
                display: block;
                border:1px solid #999;
                border-radius:3px;
            }

            .huanli{height: 49px;background:rgb(255,12,67);position: fixed;bottom: 0px;z-index: 99999;width: 100%;text-align: center;line-height: 49px;font-size: 16px;color: #fff}

        </style>
        <div class="content1">
            <div class="row hnav">
                <div class="col-50 dyq" onclick="dyq()">抵用券</div>
                <div class="col-50 wydh">我要兑换</div>
            </div>

            <div class="text">
                <input type="text" name="cdkey" id="cdkey" placeholder="请输入兑换码">
            </div>

            <div class="huanli" onclick="handle()">立即兑换</div>

        </div>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script>

    function dyq(){
        window.location.href = '/Home/Coupon/index'
    }
    function handle(){
        $.post("<?php echo U('Coupon/handle');?>","cdkey="+$("#cdkey").val(),function (data) {
            $temp = $.parseJSON(data)
            if($temp['status'] == "200"){
                $.confirm('兑换成功！是否查看我的抵用券？',
                    function () {
                        window.location.href = '/Home/Coupon/index'
                    },
                    function () {
                        $('#cdkey').val('');
                    }
                );
            }else{
                $.alert($temp['text']);
            }
        })
    }

</script>
</body>
</html>