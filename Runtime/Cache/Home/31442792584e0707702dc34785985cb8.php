<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>填写物流信息</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <link rel="stylesheet" href="/Public/resource/dist/vux.css?<?php echo C('CDN_VERSION');?>">
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
            <div class="list-block">
                <ul>
                    <!-- Text inputs -->
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">退款编号</div>
                                <div class="item-input">
                                    <input type="text" value="<?php echo ($data["returnid"]); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">退货金额</div>
                                <div class="item-input">
                                    <input type="text" value="<?php echo ($data["money"]); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">退货原因</div>
                                <div class="item-input">
                                    <input type="text" value="<?php echo ($data["content"]); ?>" readonly>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">物流公司</div>
                                <div class="item-input">
                                    <select name="express">
                                        <option value ="顺丰快递">顺丰快递</option>
                                        <option value ="圆通快递">圆通快递</option>
                                        <option value="韵达快递">韵达快递</option>
                                        <option value="中通快递">中通快递</option>
                                        <option value="传喜物流">传喜物流</option>
                                        <option value="德邦物流">德邦物流</option>
                                        <option value="EMS">EMS</option>
                                        <option value="全峰快递">全峰快递</option>
                                        <option value="申通快递">申通快递</option>
                                        <option value="天天快递">天天快递</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item-content">
                            <div class="item-inner">
                                <div class="item-title label">物流单号</div>
                                <div class="item-input">
                                    <input type="hidden" name="snopid" value="<?php echo $_GET['id'];?>">
                                    <input type="text" placeholder="请输入快递单号" name="logistics">
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="queding" @click="apply">确定</div>
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
                $.post("/Home/OrderReturnGoods/save",$("#from1").serialize(),function(data){
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