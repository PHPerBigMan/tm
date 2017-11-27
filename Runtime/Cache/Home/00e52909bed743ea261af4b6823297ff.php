<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo ($config['site_name']); ?></title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="stylesheet" href="//g.alicdn.com/msui/sm/0.6.2/css/??sm.min.css,sm-extend.min.css">
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/font/iconfont.css?<?php echo C('CDN_VERSION');?>">
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/css/hindex.css?<?php echo C('CDN_VERSION');?>">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <script src="<?php echo C('CDN_PATH');?>/Public/resource/hw/js/vue.lazyimg.js"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">
        wx.config(<?php echo ($jssdk); ?>);

        wx.ready(function () {
            <?php if($url == '' ): ?>wx.hideOptionMenu();<?php endif; ?>
            wx.onMenuShareAppMessage({
                title: "<?php echo ($config['site_name']); ?>",
                desc: "<?php echo ($config['site_name']); ?>111",
                link: "<?php echo ($url); ?>",
                imgUrl: "http://shopceshi.hw.sunday.so<?php echo ($config['site_logo']); ?>",
            });
            wx.onMenuShareTimeline({
                title: "<?php echo ($config['site_name']); ?>", // 分享标题
                link: "<?php echo ($url); ?>", // 分享链接
                imgUrl: "<?php echo C('SITE_PATH'); echo ($config['site_logo']); ?>", // 分享图标
            });

        });

    </script>
    <script type="text/javascript">
        Vue.use(Vue.lazyimg,{
            fadein: false,
            nohori: false,
            speed: 0
        })
    </script>
    <style>
        .tel{width: 44px; height:44px;display: block;background: url("<?php echo C('CDN_PATH');?>/Public/resource/images/icon_kefu.png");background-size: cover;position: absolute;right: 3px; bottom: 100px;z-index: 4}
    </style>
</head>
<body>
<div class="page-group">
    <div class="page">
        <div class="qianbao" @click="qianbao"></div>
        <a href="tel:<?php echo ($tel["value"]); ?>" class="external">
        <div class="tel"></div>
        </a>
        <!----关注我们弹出框---->
        <div class="gzbox">
            <p>长按识别图中二维码关注我们</p>
            <img data-src="<?php echo C('CDN_PATH');?>/Public/resource/images/tm.jpg?<?php echo C('CDN_VERSION');?>">
            <div class="gzbtn" @click="closegzbox">关闭</div>
        </div>
        <div class="allbg" @click="closegzbox"></div>
        <!----关注我们弹出框---->

        <div class="tjbox">
            <div class="ttop">
                <img src="<?php echo C('CDN_PATH');?>/Public/resource/images/lijituiguang@2x.png?<?php echo C('CDN_VERSION');?>" width="100">
            </div>
            <div class="ttcenter">
                <p>方法一：微信内直接分享</p>
                <p class="p1">点击右上角        进行分享</p>
                <p>方法二：复制一下链接进行转发推广</p>
                <p class="p1 p2"><?php echo (get_duan_url($url)); ?></p>
                <p>方法三：专属二维码海报推广</p>
                <p class="p1">点击生成海报，分享给好友</p>
                <div id="datu" @click="showcode"></div>
                <div class="allbg2" @click="closed2"></div>
            </div>
            <div class="tfooter">
                <a href="/Home/goods/tglist"> <button type="button" class="btn btn-success">推广员中心</button></a>
                <button type="button" class="btn btn-default" @click="closegzbox">关闭</button>
            </div>
        </div>


        <nav class="bar bar-tab">
            <a class="tab-item active" href="/">
                <span class="iconfont icon-shouye"></span>
                <span class="tab-label">首页</span>
            </a>
            <a class="tab-item" href="/Home/goods/xinpin">
                <span class="iconfont icon-biaoqian1"></span>
                <span class="tab-label">全部商品</span>
            </a>
            <a class="tab-item" href="<?php echo U('cart/index');?>">
                <span class="iconfont icon-gouwudaib"></span>
                <span class="tab-label">购物车</span>
            </a>
            <a class="tab-item" href="<?php echo U('center/index');?>">
                <span class="iconfont icon-jikediancanicon03"></span>
                <span class="tab-label">个人中心</span>
            </a>
        </nav>
        <div class="content infinite-scroll infinite-scroll-bottom">
            <form action="/Home/goods/lists" method="get">
                <div class="bar bar-header-secondary" @click="tiao">
                    <div class="searchbar" style="position: absolute;padding-right: 60px;width: 100%">
                        <a class="searchbar-cancel" style="font-size: 14px">取消</a>
                        <div class="search-input">
                            <label class="icon icon-search" for="search"></label>
                            <input type="search" id='search' placeholder='搜索您需要的商品' name="keyword"/>
                        </div>
                    </div>
                    <div class="flword">分类</div>
                </div>
            </form>
            <div class="swiper-container" data-space-between='10' data-autoplay="3000" id="lb1">
                <div class="swiper-wrapper">
                    <?php if(is_array($carousel)): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["position"] == 1 ): ?><div class="swiper-slide">
                            <a href="<?php echo ($vo["url"]); ?>">
                            <img src="<?php echo ($vo["carouselimg"]); ?>" alt="<?php echo ($vo["title"]); ?>">
                            </a>
                        </div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="content-padded grid-demo fenlei">
                <div class="row">
                    <template v-for="(mykey,item) in classify">
                    <div class="col-25" @click="url2(item.classifyid)">
                        <img :src="item.ico" style="border-radius: 50%">
                        <p>{{ item.name }}</p>
                    </div>
                    </template>
                    <div class="col-25" @click="url1">
                        <img src="<?php echo C('CDN_PATH');?>/Public/resource/images/quanbu.png?<?php echo C('CDN_VERSION');?>" style="border-radius: 50%">
                        <p>查看全部</p>
                    </div>
                </div>
            </div>

            <div class="notice">
                <img src="<?php echo C('CDN_PATH');?>/Public/resource/images/notice.png?<?php echo C('CDN_VERSION');?>" width="40">
                <div class="ncontent">
                    <div class="d1" id="div1">
                        <span class="div2" id="div2">
                            <?php echo ($config['notice']); ?>
                        </span>
                        <span id="div3" class="div2"></span>
                        <span id="div4" class="div2"></span>
                    </div>
                </div>
                <script language="javascript" type="text/javascript">
                    var s,s2,s3,timer;
                    function init(){
                        s=getid("div1");
                        s2=getid("div2");
                        s3=getid("div3");
                        s4=getid("div4");
                        s3.innerHTML=s2.innerHTML;
                        s4.innerHTML=s2.innerHTML;
                        timer=setInterval(mar,30)
                    }
                    function mar(){
                        if(s2.offsetWidth<=s.scrollLeft){
                            s.scrollLeft-=s2.offsetWidth;
                        }else{s.scrollLeft++;}
                    }
                    function getid(id){
                        return document.getElementById(id);
                    }
                    window.onload=init;
                </script>
                <img src="<?php echo C('CDN_PATH');?>/Public/resource/images/btn_gaunzhu.png?<?php echo C('CDN_VERSION');?>" width="80" style="position: absolute;right: 10px;top: 5px;margin-top: 0px;" @click="guanzhu">
            </div>

            <div style="margin-top: 0px" class="imgbox">
                <?php if(is_array($carousel)): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["position"] == 2 ): ?><a href="<?php echo ($vo["url"]); ?>">
                            <img src="<?php echo ($vo["carouselimg"]); ?>" alt="<?php echo ($vo["title"]); ?>" style="max-width: 100%">
                        </a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>

            <div class="allbox">
                <ul>
                    <template v-for="(mykey,item) in index[0]">
                        <li>
                            <a href="/Home/goods/detail/?id={{item.commodityid}}">
                                <img src="/Public/resource/hw/images/grey.gif" v-lazyload:opt.fadein="item.thumbnail">
                                <p>{{ item.title }}</p>
                                <p><b>￥{{ item.current }}</b><s>￥{{ item.original }}</s></p>
                            </a>
                        </li>
                    </template>
                </ul>
                <div style="clear: both;"></div>
            </div>

            <div style="margin-top: 0px" class="imgbox">
                <?php if(is_array($carousel)): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["position"] == 3 ): ?><a href="<?php echo ($vo["url"]); ?>">
                            <img src="<?php echo ($vo["carouselimg"]); ?>" alt="<?php echo ($vo["title"]); ?>" style="max-width: 100%">
                        </a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>

            <div class="allbox">
                <ul>
                    <template v-for="(mykey,item) in index[1]">
                        <li>
                            <a href="/Home/goods/detail/?id={{item.commodityid}}">
                                <img src="/Public/resource/hw/images/grey.gif" v-lazyload:opt.fadein="item.thumbnail">
                                <p>{{ item.title }}</p>
                                <p><b>￥{{ item.current }}</b><s>￥{{ item.original }}</s></p>
                            </a>
                        </li>
                    </template>
                </ul>
                <div style="clear: both;"></div>
            </div>

            <div style="margin-top: 0px" class="imgbox">
                <?php if(is_array($carousel)): $i = 0; $__LIST__ = $carousel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["position"] == 4 ): ?><a href="<?php echo ($vo["url"]); ?>">
                            <img src="<?php echo ($vo["carouselimg"]); ?>" alt="<?php echo ($vo["title"]); ?>" style="max-width: 100%">
                        </a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>

            <div class="allbox">
                <ul>
                    <template v-for="(mykey,item) in index[2]">
                        <li>
                            <a href="/Home/goods/detail/?id={{item.commodityid}}">
                                <img src="/Public/resource/hw/images/grey.gif" v-lazyload:opt.fadein="item.thumbnail">
                                <p>{{ item.title }}</p>
                                <p><b>￥{{ item.current }}</b><s>￥{{ item.original }}</s></p>
                            </a>
                        </li>
                    </template>
                </ul>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
</div>

<script type='text/javascript' src='//g.alicdn.com/sj/lib/zepto/zepto.min.js' charset='utf-8'></script>
<script type="text/javascript" src="<?php echo C('CDN_PATH');?>/Public/resource/hw/js/jquery.qrcode.min.js?<?php echo C('CDN_VERSION');?>"></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/config.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script type='text/javascript' src='//g.alicdn.com/msui/sm/0.6.2/js/??sm.min.js,sm-extend.min.js' charset='utf-8'></script>
<script type='text/javascript' src='<?php echo C('CDN_PATH');?>/Public/resource/hw/js/demos.js?<?php echo C('CDN_VERSION');?>' charset='utf-8'></script>
<script>
    $("#datu").qrcode({
        render: "canvas", //table方式
        width: 50, //宽度
        height:50, //高度
        text: "<?php echo ($url); ?>" //任意内容
    });

    var vm = new Vue({
        el: 'body',
        data: {
            data : <?php echo (json_encode($data)); ?>,
            classify : <?php echo (json_encode($classify)); ?>,
            index : <?php echo (json_encode($index)); ?>,
            url : "<?php echo ($url); ?>",
        },
        methods: {
            tiao:function () {
                window.location.href = '/Home/goods/search'
            },
            url2: function (id) {
                window.location.href = '/Home/goods/lists/?id='+id
            },
            url1: function (id) {
                window.location.href = '/Home/goods/search/'
            },
            guanzhu:function(){
                $(".gzbox img").attr("src",$(".gzbox img").attr('data-src'))
                $(".allbg,.gzbox").show();
            },
            closegzbox:function(){
                $(".allbg,.gzbox,.tjbox").hide();
            },
            qianbao:function(){
                if(vm.url == ""){
                    window.location.href = '/Home/user/apply'
                }else{
//                    window.location.href = "/Home/user/extension"
                    $(".tjbox,.allbg").show();
                }
            },
            kefu:function(){
                if(vm.url == ""){
                    window.location.href = '/Home/user/apply'
                }else{
                    window.location.href = "/Home/user/haibao?id=<?php echo ($_SESSION['user']['id']); ?>"
//                    $(".tjbox,.allbg").show();
                }
            },
            showcode:function(){
                window.location.href = "/Home/user/haibao?id=<?php echo ($_SESSION['user']['id']); ?>"
            },
        }
    })
</script>
</body>
</html>