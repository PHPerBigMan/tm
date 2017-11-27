<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="//cdn.bootcss.com/jquery/2.0.2/jquery.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <style>
        html{overflow-y: scroll}
        body{overflow-y: scroll;font-size: 13px;}
        table>tbody>tr>td,table>thead>tr>th{text-align:center;vertical-align:middle;}
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;padding-bottom: 80px;">
    <a type="button" class="am-btn am-btn-warning am-btn-sm" style="margin-bottom: 10px;" @click="addone"><i class="am-icon-plus"></i>添加优惠券</a>
    <form action="/admin/Coupon/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">
        <table class="am-table am-table-striped">
            <thead>
            <tr>
                <th width="90">ID</th>
                <th>优惠券图片</th>
                <th>规则</th>
                <th>面额(元)</th>
                <th>有效期</th>
                <th>数量</th>
                <th width="180">操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in data">
                <td>{{ $index+1 }}</td>
                <td width="30%">
                    <img :src="item.coupon_path" width="100%" style="//border-radius: 50%">
                </td>
                <td>
                    <template v-if="item.type == 1">无门槛{{ item.facevalue }}元抵用券</template>
                    <template v-if="item.type == 2">满{{item.condition}}减{{item.facevalue}}元抵用券</template>
                </td>
                <td>
                    {{ item.facevalue }}
                </td>
                <td>
                    {{ item.starttime | time}} - {{ item.endtime | time}}
                </td>
                <td>
                    {{ item.num }}
                </td>
                <td>
                    <a type="button" class="am-btn am-btn-success am-btn-sm" @click="edit(item.id,this)"><span class="am-icon-pencil-square-o"></span>  查看</a>
                    <a type="button" class="am-btn am-btn-danger am-btn-sm" @click="del(item.id,this)"><span class="am-icon-trash-o"></span>  删除</a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
    <div style="clear: both"></div>
    <br><br>
    <div class="am-cf" style="padding:0px 30px 30px 30px;margin-bottom: 30px;">
        <div class="am-fl hw-jilu">共 {{ data.length }} 条记录</div>
        <div class="am-fr">
            <?php echo ($page); ?>
        </div>
    </div>
</div>

<!--[if lt IE 9]>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/resource/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/Public/resource/layer/layer.js"></script>
<script src="/Public/resource/assets/js/amazeui.min.js"></script>
<script src="/Public/resource/assets/js/hw-layer.js"></script>
<script src="/Public/resource/assets/js/app.js"></script>
<script type="text/javascript">
    Vue.filter("time",function(value){
        var date =new Date();
        date.setTime(value*1000);
        return date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
    });
    var vm = new Vue({
        el: 'body',
        data: {
            data:<?php echo ((isset($data) && ($data !== ""))?($data):"[]"); ?>,
        },methods: {
            addone: function (event) {
                layer_show('添加优惠券','/admin/Coupon/add',700,590)
            },
            edit:function(id,event){
                layer_show('查看优惠券','/admin/Coupon/edit/?id='+id,700,590)
            },
            del:function (id,event) {
                layer.msg('确定要删除吗？', {
                    time:0,
                    btn: ['确定', '取消'],
                    yes: function(){
                        $.get('/admin/Coupon/del/?id='+id,function (data) {
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
            }
        }
    })
</script>
</body>
</html>