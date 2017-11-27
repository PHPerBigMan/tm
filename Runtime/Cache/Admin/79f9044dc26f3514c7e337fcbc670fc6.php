<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <script src="//cdn.bootcss.com/vue/1.0.24/vue.min.js"></script>
    <style>
        .am-btn-default{background: none}
        .am-dropdown-content{z-index: 9999;background: #fff}
        .am-table img{border-radius: 50%;margin-right: 10px;}
    </style>
</head>
<body>
<div class="am-cf admin-main2">
    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0 am-animation-slide-top  hw-nav">
                <div class="am-fl am-cf">
                    <ol class="am-breadcrumb">
                        <li class="am-active">评价管理</li>
                    </ol>
                </div>
                <div class="am-fr am-cr">
                    <a class="am-btn am-btn-warning hw-shuaxin" href="javascript:location.replace(location.href);">
                        <i class="am-icon-refresh"></i>
                    </a>
                </div>
            </div>

            <div class="am-alert am-alert-secondary am-animation-scale-up" style="margin: 0px 20px;">
                <form class="am-form" action="/Admin/CommodityComment/lists.html" method="get">
                    商品ID：
                    <input type="text" class="am-input-sm" name="id" value="" style="width: 200px;display: inline-block">
                    <button type="submit" class="am-btn am-btn-secondary am-btn-sm" style="height: 34px;line-height: 14px">筛选</button>
                </form>
            </div>

            <div class="am-g am-animation-slide-right">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th width="500">商品名称</th>
                                <th>评价描述</th>
                                <th>评价人</th>
                                <!--<th>卖家回复</th>-->
                                <th>评论时间</th>
                                <th class="table-set" width="120">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="item in user">
                                <tr>
                                    <td>{{ item.commodity.title }}<img src=""> </td>
                                    <td>评价内容：{{ item.content }}</td>
                                    <td><img :src="item.user.img" width="40">{{ item.user.nickname }} </td>
                                    <!--<td>回复内容：{{ item.seller_content }}</td>-->
                                    <td>{{ item.time }}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <!--<a class="am-btn am-btn-default am-btn-xs am-text-secondary" v-on:click.stop="huifu(item.commodity_commentid)" v-if="item.seller_content == ''"><span class="am-icon-sticky-note-o"></span> 回复</a>-->
                                                <a type="button" class="am-btn am-btn-danger am-btn-sm" @click="shanchu(item.commodity_commentid,this)"><span class="am-icon-trash-o"></span> 删除</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        <div class="am-cf" style="padding:0px 30px 30px 30px;margin-bottom: 30px;">
                            <div class="am-fl hw-jilu">共 {{ user.length }} 条记录</div>
                            <div class="am-fr">
                                <?php echo ($page); ?>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- content end -->
</div>

<!--[if lt IE 9]>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/resource/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="//cdn.bootcss.com/jquery/2.0.2/jquery.min.js"></script>
<script src="/Public/resource/layer/layer.js"></script>
<script src="/Public/resource/assets/js/amazeui.min.js"></script>
<script src="/Public/resource/assets/js/hw-layer.js"></script>
<script src="/Public/resource/assets/js/app.js"></script>
<script>
    var vm = new Vue({
        el: 'body',
        data: {
            user:<?php echo ($data); ?>,
    },
    methods: {
        huifu:function (id) {
            layer.prompt({
                title: '回复',
                formType: 0 //prompt风格，支持0-2
            }, function(pass){
                $.post('/admin/CommodityComment/huifu',{id:id,content:pass},function (data) {
                    $temp = $.parseJSON(data);
                    vm.user[event.$index].seller_content = '1';
                    layer.msg($temp['text']);
                })
            });
        },
        shanchu: function (id,event) {
            layer.msg('确定要删除吗？', {
                time:0,
                btn: ['确定', '取消'],
                yes: function(){
                    $.get('/admin/CommodityComment/del/?id='+id,function (data) {
                        $temp = $.parseJSON(data);
                        if($temp['status'] == "200"){
                            vm.user.$remove(vm.user[event.$index])
                            layer.msg('删除成功！');
                        }else{
                            layer.msg($temp['text']);
                        }
                    })
                }
            });
        },
    }
    })

</script>
</body>
</html>