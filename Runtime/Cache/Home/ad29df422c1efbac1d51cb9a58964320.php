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
            .row{background: #fff;color:#000;}
            .hnav .col-50{margin-left: 0px !important;width: 50% !important}
            .hnav{text-align: center;height: 44px;line-height: 44px;font-size: 16px;}
            .dyq{background: rgb(255,12,67);color:#fff;}
            .content{background: #fff;}
            .hnav{box-shadow:0.05rem .1rem rgba(0,0,0,.3);-webkit-tap-highlight-color: transparent;}

        </style>
        <div class="content">
            <div class="row hnav">
                <div class="col-50 dyq">抵用券</div>
                <div class="col-50 wydh" onclick="conversion()">我要兑换</div>
            </div>
            <?php if(is_array($data)): foreach($data as $key=>$vo): ?><div class="card demo-card-header-pic">
                    <div valign="bottom" class="card-header color-white no-border no-padding">
                        <img class='card-cover' src="<?php echo ($vo["coupon_path"]); ?>" alt="" style="height: 80px;">
                    </div>
                </div><?php endforeach; endif; ?>
        </div>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script>

    function conversion(){
        window.location.href = '/Home/Coupon/conversion'
    }

</script>
</body>
</html>