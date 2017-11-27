<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>退货申请</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/dist/vux.css?<?php echo C('CDN_VERSION');?>">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <style>
        .page, .page-group{background: #fff}
        .queding{height: 49px;position: absolute;bottom: 0px;left: 0px;width: 100%;line-height: 49px;text-align: center;background: #ff0043;color: #fff}
        .grid-demo{background: #fff;margin: 0px;padding: .75rem}
        .row{margin-bottom: 10px;}
        input,textarea{width: 100%}
    </style>
</head>
<body>
<div class="page-group">
    <div class="page">
        <form method="post" id="from1">
        <div class="content">
            <div class="content-padded grid-demo">
                <form>
                <div class="row">
                    <div class="col-25">退款金额</div>
                    <input type="hidden" name="snopid" value="<?php echo $_GET['id'];?>">
                    <div class="col-75"><input type="text" name="money"></div>
                </div>
                <div class="row">
                    <div class="col-25">退货说明</div>
                    <div class="col-75">
                        <textarea rows="5" cols="20" name="content"></textarea>
                    </div>
                </div>
                </form>
            </div>

            <div class="queding" @click="apply">提交退货申请</div>
        </div>
        </form>
    </div>
</div>

<script src="<?php echo C('CDN_PATH');?>/Public/resource/dist/components/x-textarea/index.js?<?php echo C('CDN_VERSION');?>"></script>
<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    var vm = new Vue({
        el: 'body',
        data: {

        },
        methods: {
            apply:function () {
                $.showIndicator()
                $.post("/Home/OrderReturnGoods/handle",$("#from1").serialize(),function(data){
                    $.hideIndicator()
                    $temp = $.parseJSON(data)
                    if($temp['status'] == "200"){
                        window.location.href = "/Home/order/index"
                    }
                    $.toast($temp['text']);
                })
            }
        }
    })
</script>
</body>
</html>