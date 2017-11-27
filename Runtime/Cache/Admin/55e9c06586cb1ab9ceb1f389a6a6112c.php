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
        body{font-size: 13px;overflow-y: scroll}
        .am-panel{border: none;box-shadow: none;-webkit-box-shadow: none;margin-bottom:5px;}
        .am-table>tbody>tr>td, .am-table>tbody>tr>th, .am-table>tfoot>tr>td, .am-table>tfoot>tr>th, .am-table>thead>tr>td, .am-table>thead>tr>th{border: none}
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;">
    <form class="am-form am-form-horizontal" action="" method="post" id="from1">
        <div class="am-g am-margin-top">
            <div class="am-panel am-panel-default">
                <div class="am-panel-hd">商品信息</div>
                <div class="am-panel-bd">
                    <table class="am-table am-table-striped am-table-hover">
                        <thead>
                        <tr>
                            <th>商品名称</th>
                            <th>平台规格</th>
                            <th>条形码</th>
                            <th>数量</th>
                            <th>单价</th>
                            <th>一级分成</th>
                            <th>二级分成</th>
                            <th>三级分成</th>
                        </tr>
                        </thead>
                        <tbody>
                            <template v-for="item in data.snop">
                            <tr>
                                <td><img :src="item.snopjson['thumbnail']" width="60" style="margin-right: 10px">{{ item.snopjson['title'] }} </td>
                                <td>{{ item.attr }}</td>
                                <td>{{ item.skuid }}</td>
                                <td>{{ item.nums }}</td>
                                <td>{{ item.money }}</td>
                                <td>{{ item.snopjson.firstgraded }}%</td>
                                <td>{{ item.snopjson.secondgraded }}%</td>
                                <td>{{ item.snopjson.threegraded }}%</td>
                            </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="am-panel am-panel-default">
                <div class="am-panel-hd">基本信息</div>
                <div class="am-panel-bd">
                    <table class="am-table">
                        <tbody>
                        <tr>
                            <td width="120">订单状态：</td>
                            <td>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 0">已关闭</span>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 10">待付款</span>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 20">等待商户发货</span>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 30">等待客户收货</span>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 50">订单已完成</span>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 60">订单退款中</span>
                                <span class="am-badge am-badge-secondary am-radius" v-if="data.order_state == 70">退款完成</span>
                            </td>
                        </tr>
                        <tr>
                            <td>订单号：</td>
                            <td><?php echo ($data["uniqueid"]); ?></td>
                        </tr>
                        <tr>
                            <td>用户ID：</td>
                            <td><img src="<?php echo ($data["user"]["img"]); ?>" width="40" style="margin-right: 10px" @click="gouser(<?php echo ($data["user"]["id"]); ?>)">   <?php echo ($data["user"]["id"]); ?></td>
                        </tr>
                        <tr>
                            <td width="120">微信支付交易号：</td>
                            <td><?php echo ($data["commercial"]); ?></td>
                        </tr>
                        <tr>
                            <td width="120">下单时间：</td>
                            <td><?php echo ($data["create_time"]); ?></td>
                        </tr>
                        <tr>
                            <td width="120">支付时间：</td>
                            <td><?php echo ($data["pay_time"]); ?></td>
                        </tr>
                        <?php if($data["type"] == 1 ): ?><tr>
                                <td width="120">订单总金额：</td>
                                <td><?php echo ($data["money"]); ?></td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td width="120">订单总积分：</td>
                                <td><?php echo ($data["money"]); ?>积分</td>
                            </tr><?php endif; ?>
                        <tr>
                            <td width="120">运费：</td>
                            <td><?php echo ($data["carriage"]); ?></td>
                        </tr>
                        <tr>
                            <td width="120">备注：</td>
                            <td><?php echo ($data["beizhu"]); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="am-panel am-panel-default">
                <div class="am-panel-hd am-cf">发货信息
                    <?php if($data["extend"] != null ): ?><a type="button" class="am-btn am-btn-warning am-btn-xs am-fr" style="margin-left: 10px;" @click="wuliu(<?php echo ($data["orderid"]); ?>)">查看物流信息</a><?php endif; ?>
                    <?php if($data["order_state"] == 30 ): ?><a type="button" class="am-btn am-btn-primary am-btn-xs am-fr" @click="edit(<?php echo ($data["orderid"]); ?>)">修改发货信息</a><?php endif; ?>
                </div>
                <div class="am-panel-bd">
                    <table class="am-table">
                        <tbody>
                        <tr>
                            <td width="120">收货人：</td>
                            <td><?php echo ($data["address"]["name"]); ?> </td>
                        </tr>
                        <tr>
                            <td>省市区：</td>
                            <td><?php echo ($data["address"]["province"]); ?> <?php echo ($data["address"]["city"]); ?> <?php echo ($data["address"]["district"]); ?></td>
                        </tr>
                        <tr>
                            <td>详细地址：</td>
                            <td><?php echo ($data["address"]["address"]); ?></td>
                        </tr>
                        <tr>
                            <td>联系电话：</td>
                            <td><?php echo ($data["address"]["phone"]); ?></td>
                        </tr>
                        <tr>
                            <td>配送方式：</td>
                            <td><?php echo ($data["extend"]["express"]); ?></td>
                        </tr>
                        <tr>
                            <td>物流单号：</td>
                            <td><?php echo ($data["extend"]["couriernumber"]); ?></td>
                        </tr>
                        <tr>
                            <td>发货时间：</td>
                            <td><?php echo ($data["extend"]["settime"]); ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="am-panel am-panel-default">
                <div class="am-panel-bd">
                    <?php if($data["status"] == 1 ): ?><a type="button" class="am-btn am-btn-success am-btn-sm" @click="agree(<?php echo ($data["returnid"]); ?>)">同意退货</a>
                        <a type="button" class="am-btn am-btn-danger am-btn-sm" @click="refuse(<?php echo ($data["returnid"]); ?>)">拒绝退货</a><?php endif; ?>
                    <?php if($data["status"] == 4 ): ?><a type="button" class="am-btn am-btn-warning am-btn-sm" @click="shouhuo(<?php echo ($data["returnid"]); ?>)">确认收货</a><?php endif; ?>
                </div>
            </div>
        </div>
    </form>
    <div style="clear: both"></div>
</div>

<!--[if lt IE 9]>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/resource/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/Public/resource/layer/layer.js"></script>
<script src="/Public/resource/assets/js/amazeui.min.js"></script>
<script src="/Public/resource/assets/js/hw-layer.js"></script>
<script src="/Public/resource/assets/js/app.js"></script>
<script>
    var vm = new Vue({
        el: 'body',
        data: {
            data : <?php echo (json_encode($data)); ?>
        },
        methods: {
            edit:function (id) {
                layer_show("修改发货信息",'/admin/Order/fahuo?id='+id,400,400)
            },
            wuliu:function(id){
                layer_show("查看物流信息",'/Home/order/wuliu?id='+id,300,500)
            },
            gouser:function (id) {
                layer_full("搜索用户","/Admin/user/lists?type=2&keyword="+id+"&hw=2")
            },
        }
    })

</script>
</body>
</html>