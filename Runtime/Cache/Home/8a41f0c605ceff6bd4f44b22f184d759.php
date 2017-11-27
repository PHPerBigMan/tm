<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>推广排行榜</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script type="text/javascript" src="<?php echo C('CDN_PATH');?>/Public/resource/assets/js/zepto.qrcode.min.js?<?php echo C('CDN_VERSION');?>"></script>
    <script src="<?php echo C('CDN_PATH');?>/Public/resource/assets/js/config.js?<?php echo C('CDN_VERSION');?>"></script>
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/hw/index.css?<?php echo C('CDN_VERSION');?>">
    <script src="http://cdn.bootcss.com/vue/1.0.25/vue.min.js"></script>
    <style>
        .card-content{height: 300px;overflow-y: scroll}
        .shouyi{height: 40px;line-height: 40px;font-size: 13px}
        .shouyi .col-50{text-align: center;background: rgb(242,242,242);width: 50%;margin-left: 0px;}
        .shouyi .col-50:nth-child(1){border-right: 1px solid rgb(219,219,219)}
        .shouyi .col-50:nth-child(1) a{color: rgb(102,102,102)}
        .shouyi .col-50:nth-child(2) a{color: rgb(32,159,32)}
    </style>
</head>
<body>
<div class="page-group">
    <div class="page" id="extension">
        <!-- 这里是页面内容区 -->
        <div class="content extension">
            <div class="row shouyi">
                <div class="col-50 "><a href="/">返回店铺首页</a> </div>
                <div class="col-50"><a href="<?php echo U('user/hongbao');?>"> 查看返现记录</a></div>
            </div>
            <div class="tgbox">
                <p class="money">推广总收益：<b>￥<?php echo ((isset($money) && ($money !== ""))?($money):'0'); ?></b></p>
            </div>
            <div class="content-padded grid-demo tgbox2">
                <div class="row no-gutter">
                    <div class="col-33">
                        <img src="<?php echo C('CDN_PATH');?>/Public/resource/hw/images/icon_tuiguangpaihangbang@2x.png?<?php echo C('CDN_VERSION');?>" width="28%">
                        <p>推广排行榜</p>
                    </div>
                    <div class="col-33" @click="codeshow">
                        <img src="<?php echo C('CDN_PATH');?>/Public/resource/hw/images/icon_tuiguangerweima@2x.png?<?php echo C('CDN_VERSION');?>" width="28%">
                        <p>推广二维码</p>
                    </div>
                    <div class="col-33">
                        <a href="/Home/goods/tglist">
                            <img src="<?php echo C('CDN_PATH');?>/Public/resource/hw/images/icon_jiangliguize1@2x.png?<?php echo C('CDN_VERSION');?>" width="28%">
                            <p>开始推广</p>
                        </a>
                    </div>
                </div>
            </div>

            <style>
                .isauto1,.isauto2,.isauto3{max-height: 170px;overflow: hidden}
            </style>
            <div class="list-block contacts-block">
                <div class="list-group">
                    <ul>
                        <li class="paihang phfirst">
                            <div class="item-content">
                                <div class="item-inner">
                                    <div class="row">
                                        <div class="col-20">排名</div>
                                        <div class="col-50">微信昵称</div>
                                        <div class="col-30">获得奖励</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="paihang">
                                <div class="item-content">
                                    <div class="item-inner">
                                        <div class="row">
                                            <div class="col-20">NO.<?php echo ($key+1); ?></div>
                                            <div class="col-50" style="line-height: 30px;"><img src="<?php echo ($vo["img"]); ?>" width="30" style="border-radius: 50%;margin-right: 5px;float: left;"><?php echo ($vo["nickname"]); ?> </div>
                                            <div class="col-30 phmoney">￥<?php echo ($vo["money"]); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="allback" @click="codehide"></div>
        <div class="code">
            <b>我的推广二维码</b>
            <p class="codec1">dimensional code</p>
            <div id="datu"></div>
            <p class="codec2">Thank you for your attention</p>
            <p class="codec1">Wish You Happiness</p>
        </div>
        <script>
            $("#datu").qrcode({
                render: "canvas", //table方式
                width: 190, //宽度
                height:190, //高度
                text: "<?php echo ($url); ?>" //任意内容
            });
            var vm = new Vue({
                        el: 'body',
                        data: {
                            data: <?php echo ((isset($data) && ($data !== ""))?($data):"''"); ?>,
                    isauto1:true,
                    isauto2:true,
                    isauto3:true,
            },methods: {
                codehide: function () {
                    $(".code,.allback,.jiangli2").hide();
                },
                codeshow:function () {
                    if(vm.text == ""){
                        alert("您没有推广权限！");
                    }else{
                        $(".code,.allback").show();
                    }
                },
            }
            })
        </script>
        <script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
        <script src="<?php echo C('CDN_PATH');?>/Public/resource/assets/js/demos.js?<?php echo C('CDN_VERSION');?>"></script>
    </div>
</div>
</body>
</html>