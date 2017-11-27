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
        .am-btn-sm{margin-right: 10px;}
    </style>
</head>
<body>
<div class="am-cf admin-main2">
    <!-- content start -->
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0 hw-nav">
                <div class="am-fl am-cf">
                    <ol class="am-breadcrumb">
                        后台管理员帐号管理
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

            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-check"><input type="checkbox" /></th>
                                <th class="table-id">ID</th>
                                <th class="table-title">昵称</th>
                                <th class="table-author am-hide-sm-only">帐号</th>
                                <th class="table-date am-hide-sm-only" width="250">角色</th>
                                <th class="table-set" width="180">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="item in data">
                                <tr>
                                    <td><input type="checkbox" /></td>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{ item.name }}</td>
                                    <td class="am-hide-sm-only">{{ item.account }}</td>
                                    <td class="am-hide-sm-only">{{ item.role.title }}</td>
                                    <td>
                                        <div class="am-btn-toolbar">
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a type="button" class="am-btn am-btn-success am-btn-sm" @click="edit(item.id,this)"><span class="am-icon-pencil-square-o"></span>  编辑</a>
                                                <a type="button" class="am-btn am-btn-danger am-btn-sm" @click="del(item.id,this)"><span class="am-icon-trash-o"></span>  删除</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                        <div class="am-cf" style="padding:0px 30px 30px 30px;margin-bottom: 30px;">
                            <div class="am-fl hw-jilu">共 {{ data.length }} 条记录</div>
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
            data:<?php echo ($data); ?>,
    },
    methods: {
        add: function (event) {
            layer_show("添加管理员","/admin/Admin/add",500,400)
        },
        edit: function (id) {
            layer_show("编辑管理员",'/admin/Admin/edit/?id='+id,500,400)
        },
        del: function (id,event) {
            layer.msg('确定要删除吗？', {
                time:0,
                btn: ['确定', '取消'],
                yes: function(){
                    $.get('/admin/Admin/del/?id='+id,function (data) {
                        $temp = $.parseJSON(data);
                        if($temp['status'] == "200"){
                            vm.data.$remove(vm.data[event.$index])
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