<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo ($data["title"]); ?></title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/hw/detail.css?<?php echo C('CDN_VERSION');?>">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script src="http://cdn.bootcss.com/zepto/1.1.5/zepto.min.js"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo ($jssdk); ?>);
        wx.ready(function () {
            <?php if($url == '' ): ?>wx.hideOptionMenu();<?php endif; ?>
            wx.onMenuShareAppMessage({
                title: '<?php echo (trim($data["title"])); ?>',
                desc: '<?php echo (trim($data["title"])); ?>',
                link: '<?php echo ($url); ?>',
                imgUrl: '<?php echo C('SITE_PATH'); echo ($data["thumbnail"]); ?>',
            });
            wx.onMenuShareTimeline({
                title: '<?php echo (trim($data["title"])); ?>', // 分享标题
                link: '<?php echo ($url); ?>', // 分享链接
                imgUrl: '<?php echo C('SITE_PATH'); echo ($data["thumbnail"]); ?>', // 分享图标
            });

            var img = new Array();
            $(".detailbox img").each(function(i){
                $src = $(this).attr('src')
                if($src.indexOf('sunday.so') == -1){
                    img[i] = "<?php echo C('SITE_PATH');?>"+ $src
                }else{
                    img[i] = $src
                }
            })

            $(".detailbox img").click(function(){
                $index = $(".detailbox img").index(this)
                wx.previewImage({
                    current: img[$index],
                    urls: img
                });
            })
        });
    </script>
    <style>
        .qianbao{width: 45px; height:45px;display: block;background: url("<?php echo C('CDN_PATH');?>/Public/resource/images/icon_tuijian@2x.png");background-size: cover;position: absolute;right:3px; bottom: 95px;z-index: 4}
        .gouwu1{width: 45px; height:45px;display: block;background: url("<?php echo C('CDN_PATH');?>/Public/resource/images/icon_gouwuche@2x.png");background-size: cover;position: absolute;right: 3px; bottom: 55px;z-index: 4}
        .dai{width: 45px; height:45px;display: block;background: url("<?php echo C('CDN_PATH');?>/Public/resource/images/icon_kefu@2x.png");background-size: cover;position: absolute;right:3px; bottom: 140px;z-index: 4}*/
        /*.tel{width: 44px; height:44px;display: block;background: url("<?php echo C('CDN_PATH');?>/Public/resource/images/icon_kefu@2x.png");background-size: cover;position: absolute;right: 3px; bottom: 140px;z-index: 4}*!*/
        .allbg { background: #000;filter: alpha(opacity=60);  opacity: 0.6;  position: fixed;  left: 0px;  top: 0px;  width: 100%;  height: 100%;  overflow: hidden;  z-index: 919;display: none  }
        .allbg2 { background: #000;display: none;  filter: alpha(opacity=100);  opacity: 1;  position: fixed;  left: 0px;  top: 0px;  width: 100%;  height: 100%;  overflow: hidden;  z-index: 8001;  }
        .tjbox{width: 14rem;min-height: 300px;background: #fff;position: absolute;top: 4rem;z-index: 999;left: 50%;margin-left: -7rem;border-radius: 4px;padding: 10px 0px;display: none}
        .ttop{text-align: center;padding-bottom: 10px;padding-top: 10px;}
        .ttcenter{border-top: 1px solid #e6e6e6;border-bottom: 1px solid #e6e6e6;padding: 12px 15px;position: relative}
        .ttcenter p{margin: 0px;font-size: 13px}
        p.p1{font-size: 12px;color: #7b7b7b;margin-bottom: 15px;}
        p.p2{border: 1px solid #e5e5e5;border-radius: 4px;padding: 8px;}
        #datu{position: absolute;right: 20px;bottom: 10px;}
        .tfooter{padding: 5px 10px;height: 80px}
        .btn {  display: inline-block;  padding: 6px 12px;  width: 100%;  margin-bottom: 10px;  font-size: 14px;  font-weight: 400;  line-height: 1.42857143;  text-align: center;  white-space: nowrap;  vertical-align: middle;  -ms-touch-action: manipulation;
            touch-action: manipulation;  cursor: pointer;  -webkit-user-select: none;  -moz-user-select: none;  -ms-user-select: none;  user-select: none;  background-image: none;  border: 1px solid transparent;  border-radius: 4px;  }
        .btn-default {  color: #333;  background-color: #fff;  border-color: #ccc;}
        .btn-success {  color: #fff;  background-color: #5cb85c;  border-color: #4cae4c;}
        .edui-upload-video{width: 100%}

    </style>
</head>
<body>
<div class="page-group">
    <div class="page">
        <div class="qianbao" @click="qianbao"></div>
        <div class="gouwu1" @click="gouwu2"></div>
        <div class="dai" @click="dai"></div>
        <!--<a href="tel:<?php echo ($tel["value"]); ?>" class="external">-->
            <!--<div class="tel"></div>-->
        <!--</a>-->
        <div class="allbg"></div>
        <div class="tjbox">
            <div class="ttop">
                <img src="<?php echo C('CDN_PATH');?>/Public/resource/images/lijituiguang@2x.png?<?php echo C('CDN_VERSION');?>" width="100">
            </div>
            <div class="ttcenter">
                <p>方法一：微信内直接分享</p>
                <p class="p1">点击右上角        进行分享</p>
                <p>方法二：复制一下链接进行转发推广</p>
                <p class="p1 p2"><?php echo (get_duan_url($url)); ?></p>
                <p>方法三：使用专属二维码推广</p>
                <p class="p1">点击放大二维码，客户端进行扫描</p>
                <div id="datu" @click="showcode"></div>
            </div>
            <div class="tfooter">
                <a href="/Home/goods/tglist"> <button type="button" class="btn btn-success">推广员中心</button></a>
                <button type="button" class="btn btn-default" @click="close">关闭</button>
            </div>
        </div>

        <nav class="bar bar-tab">
            <!--<div class="kefu">-->
                <!--<a href="/Home/user/kefu">-->
                    <!--<span class="icon icon-message"></span>-->
                    <!--<span>客服</span>-->
                <!--</a>-->
            <!--</div>-->
            <div class="kefu">
                <a href="/">
                    <span class="icon icon-home" style="font-size: 17px"></span>
                    <span>首页</span>
                </a>
            </div>
            <div class="kefu love" @click="del(<?php echo ($data["commodityid"]); ?>)" v-if="islove == 1">
                <span class="icon icon-star"></span>
                <span>收藏</span>
            </div>

            <div class="kefu" @click="love" v-if="islove == 0">
                <span class="icon icon-star"></span>
                <span>收藏</span>
            </div>
            <div class="shidai" @click="shidai">
                试戴眼镜
            </div>
            <div class="gouwu" @click="gouwu">
                加入购物车
            </div>
            <div class="goumai" @click="goumai">
                立即购买
            </div>
        </nav>
        <div class="content">
            <div class="row hnav">
                <div class="col-50 spxq">商品详情</div>
                <div class="col-50" @click="pingjia">用户评价</div>
            </div>
            <div class="swiper-container" data-space-between='10'>
                <div class="swiper-wrapper">
                    <?php if(is_array($data["carrousel"])): $i = 0; $__LIST__ = $data["carrousel"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="swiper-slide">
                            <img src="<?php echo C('CDN_PATH'); echo ($vo); ?>?<?php echo C('CDN_VERSION');?>" alt="<?php echo ($vo["title"]); ?>">
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
            <div class="content-padded goodsdetail">
                <h1 id="previewImage"><?php echo ($data["title"]); ?></h1>
                <!--<h1><?php echo ($data["title"]); ?><br>当前地址：/Home/goods/detail/?id=79<br>分享url：<?php echo ($url); ?><br>推广ID：<?php echo ($from); ?></h1>-->
                <div class="row">
                    <div class="col-50">
                        <b>￥<?php echo ($data["current"]); ?></b>
                        <s>￥<?php echo ($data["original"]); ?></s>
                    </div>
                    <div class="col-50 tr">销量：<?php echo ($data["sales"]); ?>件</div>
                </div>
                <div class="row">
                    <?php if($data["carriage"] != 0 ): ?><div class="col-33">运费：<?php echo ($data["carriage"]); ?>元</div>
                        <?php else: ?>
                        <div class="col-33">运费：包邮</div><?php endif; ?>
                    <div class="col-33 tc">库存：<?php echo ($data["size"]); ?>件</div>
                    <div class="col-33 tr">送<?php echo ($data["integral"]); ?>积分</div>
                </div>
            </div>

            <div class="tuijian">
                <p class="mjtj">卖家推荐</p>
                <div class="row">
                    <?php if(is_array($data["tuijian"])): $i = 0; $__LIST__ = $data["tuijian"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-33">
                            <a href="/Home/goods/detail/?id=<?php echo ($vo["commodityid"]); ?>">
                                <img src="<?php echo C('CDN_PATH'); echo ($vo["thumbnail"]); ?>?<?php echo C('CDN_VERSION');?>">
                                <p><?php echo ($vo["title"]); ?></p>
                                <b>￥<?php echo ($vo["current"]); ?></b>
                            </a>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>

            <div class="detailbox">
                <?php echo ($data["content"]); ?>
            </div>
        </div>
    </div>
    <div class="popup popup-about">
        <div class="content-block">
            <div class="ptitle">
                <div class="pimg">
                    <img src="<?php echo C('CDN_PATH'); echo ($data["thumbnail"]); ?>?<?php echo C('CDN_VERSION');?>">
                </div>
                <div class="pbody">
                    <b>￥{{ current_money }}</b>
                    <p>库存：{{ current_attr.stock }} 件</p>
                </div>

                <span class="iconfont guanbi" @click="closed">&#xe60b;</span>
            </div>
            <div class="guige">
                <template v-for="item in shuxingji">
                <p>{{ item.attr }}</p>
                <ul>
                    <template v-for="val in item.val">
                    <li>{{ val }}</li>
                    </template>
                </ul>
                <div class="clear"></div>
                </template>
            </div>
            <div class="nub">
                <div class="row" style="height: 25px">
                    <div class="col-50">购买数量</div>
                    <div class="col-50 tr">
                        <span @click="jian">-</span>
                        <span>{{ nubs }}</span>
                        <span @click="jia">+</span>
                    </div>
                </div>
            </div>
            <div style="height: 49px;width: 100%;position: absolute;bottom: 0px;left: 0px;color: #fff" v-if="type1 == 2">
                <div style="width: 50%;height: 49px;display: inline-block;line-height: 49px;text-align: center;background: #ff9414" @click="queding(1)">加入购物车</div>
                <div style="width: 50%;height: 49px;display: inline-block;line-height: 49px;text-align: center;background: #ff0043;float: right" @click="queding(2)">确定</div>
            </div>
            <div class="queding" @click="queding('')" v-if="type1 == 1">确定</div>
        </div>
    </div>
</div>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type="text/javascript" src="<?php echo C('CDN_PATH');?>/Public/resource/hw/js/jquery.qrcode.min.js?<?php echo C('CDN_VERSION');?>"></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    $("#datu").qrcode({
        render: "canvas", //table方式
        width: 50, //宽度
        height:50, //高度
        text: "<?php echo ($url); ?>" //任意内容
    });

    $(function () {
        $(".detailbox img").each(function(){
            $(this).attr('href',$(this).attr('src'));
        })

        $(".guige ul li").click(function () {
            $(this).siblings().removeClass('active')
            if($(this).hasClass('active')){
                $(this).removeClass('active')
            }else{
                $(this).addClass('active')
            }

            var sku = new Array();
            $(".guige ul").each(function () {
                if($(this).find('li.active').text() != null){
                    sku.push($(this).find('li.active').text())
                }
            })
            vm.sku = sku.join(',')

            if(sku.length >= vm.shuxingji.length){
                //后台查询价格和库存
                $.post("/Home/Goods/get_attr/",{id:<?php echo $_GET['id'];?>,sku:vm.sku},function(data){
                    vm.current_attr = data
                    vm.current_money = vm.current_attr['attr_money']
                })
            }
        })
    })

    var vm = new Vue({
        el: 'html',
        data: {
            shuxingji : <?php echo ($shuxingji); ?>,
            islove : <?php echo ((isset($data["islove"]) && ($data["islove"] !== ""))?($data["islove"]):"0"); ?>,
            nubs : 1,
            guige : 0,
            current_attr : {stock:<?php echo ($data["size"]); ?>},
            current_money:<?php echo ($data["current"]); ?>,
            type : 1,//1为购物车，2为购
            type1 : 1,
            sku : '',
            url :"<?php echo ($url); ?>"
        },
        methods: {
            jia:function(){
                if(vm.nubs >= vm.current_attr['stock']){
                    $.toast("库存不够！");
                    return
                }
                vm.nubs++;
            },
            jian:function(){
                if(vm.nubs == 1){
                    return
                }
                vm.nubs--
            },
            showcode:function(){
                window.location.href = "/Home/user/haibao?id=<?php echo ($_SESSION['user']['id']); ?>"
            },
            detail: function (event) {
                window.location.href = '/Home/goods/detail'
            },
            qianbao:function(){
                if(vm.url == ""){
                    window.location.href = '/Home/user/apply'
                }else{
                    $(".tjbox,.allbg").show();
                }
            },
            dai:function(){
                window.location.href = "/Home/user/kefu"
            },
            close:function(){
                $(".allbg,.tjbox").hide()
            },
            pingjia: function (event) {
                window.location.href = "/Home/goods/comment/?id=<?php echo $_GET['id'];?>"
            },
            shidai:function(){
                window.location.href = "<?php echo ($shidai); ?>"
            },
            gouwu: function (event) {
                vm.type = 1
                vm.type1 = 1
                $.popup('.popup-about');
            },
            gouwu2:function(){
                window.location.href = "/Home/cart/index/"
            },
            goumai: function (event) {
                vm.type = 2
                vm.type1 = 2
                $.popup('.popup-about');
            },
            closed:function () {
                $.closeModal('.popup-about')
            },
            love:function () {
                $.post('/Home/love/add',{commodityid:<?php echo $_GET['id'];?>},function (data) {
                    $temp = $.parseJSON(data)

                    if($temp['status'] == "200"){
                        vm.islove = 1
                    }
                    $.toast($temp['text']);
                })
            },
            del:function(cid) {
                $.get('/Home/love/del/?cid='+cid,function (data) {
                    $temp = $.parseJSON(data)
                    if($temp['status'] == "200"){
                        vm.islove = 0
                    }
                    $.toast($temp['text']);
                })
            },
            queding:function(type){
                if(vm.sku.length == 0){
                    $.toast("请先选择商品规格和数量!");
                    return
                }
                if(type != ''){
                    vm.type = type
                }

                if(vm.sku.split(',').length == vm.shuxingji.length){
                    if(vm.current_attr.stock == 0){
                        $.toast("已售罄");
                        return
                    }
                    $.showIndicator();
                    if(vm.type == 1){
                        $.post('/Home/cart/add_cart',{id:<?php echo $_GET['id'];?>,sku:vm.sku,nub:vm.nubs},function(data){
                            $temp = $.parseJSON(data);
                            $.toast($temp['text']);
                            $.hideIndicator();
                        })
                    }else{
                        $.post('/Home/order/set_order_from_detail',{id:<?php echo $_GET['id'];?>,sku:vm.sku,nub:vm.nubs},function(data){
                            $temp = $.parseJSON(data)
                            if($temp['status'] == "200"){
                                window.location.href = '/Home/order/jiesuan/?id='+$temp['text'];
                            }else{
                                $.toast($temp['text']);
                            }
                            $.hideIndicator();
                        })
                    }
                }else{
                    $.toast("请先选择规格!");
                }
            },
        }
    })
</script>
</body>
</html>