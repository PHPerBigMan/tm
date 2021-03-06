<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>推广员中心</title>
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
                        <a href="<?php echo U('user/paihang');?>">
                            <img src="<?php echo C('CDN_PATH');?>/Public/resource/hw/images/icon_tuiguangpaihangbang@2x.png?<?php echo C('CDN_VERSION');?>" width="28%">
                            <p>推广排行榜</p></a>
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
            <div class="list-block contacts-block tgren first" v-bind:class="{ 'isauto1': isauto1}">
                <div class="list-group">
                    <ul>
                        <li>
                            <div class="item-content item-link">
                                <div class="item-inner">
                                    <div class="item-title" v-if="data[0].length>0">一级推广人（{{ data[0].length }}人）</div>
                                    <div class="item-title" v-else>一级推广人（0人）</div>
                                    <div class="item-after" @click="firstshow">查看更多</div>
                                </div>
                            </div>
                        </li>
                        <li v-for="item in data[0]">
                            <div class="item-content">
                                <div class="item-inner">
                                    <span class="round">●</span>
                                    <p>{{ item.nickname}}</p>
                                    <p>奖励收益：<b>￥{{ item.money}}</b></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="list-block contacts-block tgren second" v-bind:class="{ 'isauto2': isauto2}">
                <div class="list-group">
                    <ul>
                        <li>
                            <div class="item-content item-link">
                                <div class="item-inner">
                                    <div class="item-title" v-if="data[1].length>0">二级推广人（{{ data[1].length }}人）</div>
                                    <div class="item-title" v-else>二级推广人（0人）</div>
                                    <div class="item-after" @click="firstshow1">查看更多</div>
                                </div>
                            </div>
                        </li>
                        <li v-for="item in data[1]">
                            <div class="item-content">
                                <div class="item-inner">
                                    <span class="round">●</span>
                                    <p>{{ item.nickname}}</p>
                                    <p>奖励收益：<b>￥{{ item.money}}</b></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="list-block contacts-block tgren three" v-bind:class="{ 'isauto3': isauto3}">
                <div class="list-group">
                    <ul>
                        <li>
                            <div class="item-content item-link">
                                <div class="item-inner">
                                    <div class="item-title" v-if="data[2].length>0">三级推广人（{{ data[2].length }}人）</div>
                                    <div class="item-title" v-else>三级推广人（0人）</div>
                                    <div class="item-after" @click="firstshow2">查看更多</div>
                                </div>
                            </div>
                        </li>
                        <li v-for="item in data[2]">
                            <div class="item-content">
                                <div class="item-inner">
                                    <span class="round">●</span>
                                    <p>{{ item.nickname}}</p>
                                    <p>奖励收益：<b>￥{{ item.money }}</b></p>
                                </div>
                            </div>
                        </li>
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
            var url  = "<?php echo ((isset($url) && ($url !== ""))?($url):""); ?>"

            $("#datu").qrcode({
                render: "canvas", //table方式
                width: 190, //宽度
                height:190, //高度
                text: url //任意内容
            });
            var vm = new Vue({
                el: 'body',
                data: {
                    data: <?php echo ((isset($data) && ($data !== ""))?($data):"''"); ?>,
                    isauto1:true,
                    isauto2:true,
                    isauto3:true,
                },methods: {
                    firstshow:function () {
                        if(vm.isauto1){
                            vm.isauto1 = false
                        }else{
                            vm.isauto1 = true
                        }
                    },
                    firstshow1:function () {
                        if(vm.isauto2){
                            vm.isauto2 = false
                        }else{
                            vm.isauto2 = true
                        }
                    },
                    firstshow2:function () {
                        if(vm.isauto3){
                            vm.isauto3 = false
                        }else{
                            vm.isauto3 = true
                        }
                    },
                    codehide: function () {
                        $(".code,.allback,.jiangli2").hide();
                    },
                    codeshow:function () {
                        console.log(vm.text)
                        if(url == ""){
                            $.confirm('您还未申请成为推广员，是否立即申请成为推广员？', '提示',
                                    function () {
                                        window.location.href ="/Home/user/apply"
                                    },
                                    function () {

                                    }
                            );
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