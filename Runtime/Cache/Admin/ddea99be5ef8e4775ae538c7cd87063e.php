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
        .am-btn-sm{margin-right: 10px;}
        .myclass{width: 400px;height: 400px;}
    </style>
</head>
<body>
<div class="am-cf admin-main2">
    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0 am-animation-slide-top hw-nav" >
                <div class="am-fl am-cf">
                    <ol class="am-breadcrumb">
                        <li class="am-active">积分商品列表</li>
                    </ol>
                </div>
                <div class="am-fr am-cr">
                    <a class="am-btn am-btn-warning hw-shuaxin" href="javascript:location.replace(location.href);">
                        <i class="am-icon-refresh"></i>
                    </a>
                    <a class="am-btn am-btn-secondary hw-shuaxin tianjia" v-on:click="add">
                        <i class="am-icon-plus"></i>
                    </a>
                </div>
            </div>
            <div class="am-alert am-alert-secondary am-animation-scale-up" style="margin: 0px 20px;">
                <form class="am-form" action="/Admin/CommodityJifen/lists.html" method="get">
                    搜索类型：
                    <select name="type" class="form-control" style="width: 120px;display: inline-block;height: 35px;font-size: 14px">
                        <option value="1">搜标题</option>
                        <option value="2">搜货号</option>
                    </select>
                    关键词：
                    <input type="text" class="am-input-sm" name="keyword" value="" style="width: 200px;display: inline-block">
                    <button type="submit" class="am-btn am-btn-secondary" style="height: 34px;line-height: 14px">筛选</button>
                </form>
            </div>
            <div class="am-g am-animation-slide-right">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th width="120">ID</th>
                                <th>缩略图</th>
                                <th>平台货号</th>
                                <th>商品标题</th>
                                <th>所需积分</th>
                                <th>兑换量</th>
                                <th class="table-set" width="250">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="item in data">
                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td><img :src="item.thumbnail" width="50" height="50"> </td>
                                    <td>{{ item.huohao }}</td>
                                    <td>{{ item.title }}</td>
                                    <td>{{ parseInt(item.current) }}分</td>
                                    <td>{{ item.sales }}件</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a type="button" class="am-btn am-btn-secondary am-btn-sm" @click="code(item.commodityid)"><span class="am-icon-qrcode"></span>  二维码</a>
                                                <a type="button" class="am-btn am-btn-success am-btn-sm" @click="edit(item.commodityid)"><span class="am-icon-pencil-square-o"></span>  编辑</a>
                                                <a type="button" class="am-btn am-btn-danger am-btn-sm" @click="shanchu(item.commodityid,this)"><span class="am-icon-trash-o"></span>  删除</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        <div class="am-cf" style="padding:0px 30px 30px 30px;margin-bottom: 30px;">
                            <div class="am-fl hw-jilu">共 {{ data.length }} 条记录</div>
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
            data : <?php echo ($data); ?>
        },
        methods: {
            code:function (id) {
                layer.open({
                    type: 2,
                    title: false,
                    shadeClose: true,
                    shade: 0.7,
                    closeBtn:0,
                    area: ['210px', '210px'],
                    content: '/admin/CommodityJifen/code/?id='+id
                });
            },
            add: function (id) {
                layer_full("添加普通商品",'/admin/CommodityJifen/add/')
            },
            edit: function (id) {
                layer_full("修改普通商品",'/admin/CommodityJifen/edit/?id='+id)
            },
            shanchu: function (id,event) {
                layer.msg('确定要删除吗？', {
                    time:0,
                    btn: ['确定', '取消'],
                    yes: function(){
                        $.get('/admin/CommodityJifen/del/?id='+id,function (data) {
                            $temp = $.parseJSON(data);
                            if($temp['status'] == "200"){
                                vm.carousel.$remove(vm.carousel[event.$index])
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