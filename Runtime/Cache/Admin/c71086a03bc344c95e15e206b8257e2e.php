<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script type="text/javascript" src="http://lib.h-ui.net/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
    <style>
        body{overflow-y: auto;font-size: 13px;}
        .am-tabs-bd{border:0px;}
        .am-icon-check-circle{color:green;}
        .am-icon-times-circle{color:red;}
        table>tbody>tr>td,table>tbody>tr>th{text-align:center;vertical-align:middle;}
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;">
<?php if($data["id"] != '' ): ?><div class="am-tabs"  data-am-tabs="{noSwipe: 1}">
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <li class="am-active"><a href="#tab1">优惠券详情</a></li>
            <li><a href="#tab2">查看兑换码</a></li>
        </ul>
        <div class="am-tabs-bd">
            <div class="am-tab-panel am-fade am-in am-active" id="tab1"><?php endif; ?>
                <form action="/admin/Coupon/handle" method="post" class="am-form" onsubmit="return handle()" id="form1">

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-3 am-u-md-2 am-text-right">种类</div>
                        <div class="am-u-sm-3 am-u-md-5 am-u-end col-end">
                            <select name="type" id="type" class="form-control valid" aria-invalid="false" style="height: 35px;font-size: 13px">
                                <option value="1" <?php echo ($data['type']!=2?"selected":""); ?>>无门槛抵用券</option>
                                <option value="2" <?php echo ($data['type']==2?"selected":""); ?>>满减抵用券</option>
                            </select>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-3 am-u-md-2 am-text-right">面额</div>
                        <div class="am-u-sm-3 am-u-md-5">
                            <input type="number" class="am-input-sm" name="facevalue" placeholder="请输入面额" value="<?php echo ($data["facevalue"]); ?>" max="999" required>
                        </div>
                        <div class="am-hide-sm-only am-u-md-5">注：最大面额为999</div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-3 am-u-md-2 am-text-right">开始时间</div>
                        <div class="am-u-sm-3 am-u-md-5">
                            <input type="text" class=" am-input-sm" name="starttime"  placeholder="请选择开始时间" value="<?php echo (date("Y-m-d",$data['starttime']?$data['starttime']:"")); ?>" data-am-datepicker readonly required style="cursor: pointer;" required/>
                        </div>
                        <div class="am-hide-sm-only am-u-md-6"></div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-3 am-u-md-2 am-text-right">结束时间</div>
                        <div class="am-u-sm-3 am-u-md-5">
                            <input type="text" class=" am-input-sm" name="endtime"  placeholder="请选择结束时间" value="<?php echo (date("Y-m-d",$data['endtime']?$data['endtime']:"")); ?>" data-am-datepicker readonly required style="cursor: pointer;" required/>
                        </div>
                        <div class="am-hide-sm-only am-u-md-6"></div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-3 am-u-md-2 am-text-right">下限</div>
                        <div class="am-u-sm-3 am-u-md-5">
                            <input type="number" id="condition" class="am-input-sm" name="condition" placeholder="请输入下限" value="<?php echo ($data["condition"]); ?>" required>
                        </div>
                        <div class="am-hide-sm-only am-u-md-5">注：如果是无门槛抵用券，下限不填</div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-2 am-u-md-2 am-text-right">数量</div>
                        <div class="am-u-sm-3 am-u-md-5">
                            <input type="number" class="am-input-sm" name="num" placeholder="请输入数量" value="<?php echo ($data["num"]); ?>" required>
                        </div>
                        <div class="am-hide-sm-only am-u-md-2"></div>
                    </div>

                    <div class="am-g am-margin-top-sm">
                        <div class="am-u-sm-8 am-u-sm-offset-3">
                            <?php if($data["id"] == '' ): ?><button type="submit" class="am-btn am-btn-primary">添加优惠券</button><?php endif; ?>
                        </div>
                    </div>
                </form>
<?php if($data["id"] != '' ): ?></div>
            <div class="am-tab-panel am-fade" id="tab2">
                <form action="<?php echo U('Coupon/excel');?>" method="post">
                    <input type="hidden" name="excel" value="<?php echo ($data["id"]); ?>">
                    <button type="submit" class="am-btn am-btn-success">导出兑换码</button>
                </form>
                <br><br>
                <table class="am-table am-table-striped am-table-hover">
                    <tr>
                        <th>ID</th>
                        <th>兑换码</th>
                        <th>是否发放</th>
                        <th>是否领取</th>
                    </tr>
                    <?php if(is_array($data["cdkey"])): foreach($data["cdkey"] as $key=>$v): ?><tr>
                            <td><?php echo ($key+1); ?></td>
                            <td><?php echo ($v["cdkey"]); ?></td>
                            <td><?php if(($v["is_issue"]) == "0"): ?><span class='am-badge am-badge-warning am-radius' onclick='handle_issue(this,<?php echo ($v["id"]); ?>)' style="cursor:pointer;">点击发放</span><?php else: ?><span class='am-icon-check-circle'></span><?php endif; ?></td>
                            <td><?php echo ($v["getuid"]==0?"<span class='am-icon-times-circle'></span>":"<span class='am-icon-check-circle'></span>"); ?></td>
                        </tr><?php endforeach; endif; ?>
                </table>
            </div>
        </div>
    </div><?php endif; ?>
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
    function handle() {
        $.post("<?php echo U('Coupon/handle');?>",$("#form1").serialize(),function (data) {
            $temp = $.parseJSON(data)
            if($temp['status'] == "200"){
                layer.msg($temp['text'],{icon:1,time:1000},function () {
                    var index = parent.layer.getFrameIndex(window.name);
                    parent.location.reload()
                    parent.layer.close(index);
                })
            }else{
                layer.msg($temp['text'],{icon:2,time:1000});
            }
        })
        return false;
    }
    function handle_issue(t,id) {
        $.post("<?php echo U('Coupon/handle');?>","id="+id,function (data) {
            $temp = $.parseJSON(data)
            if($temp['status'] == "200"){
                $(t).replaceWith("<span class='am-icon-check-circle'></span>");
                layer.msg($temp['text'],{icon:1,time:1000});

            }else{
                layer.msg($temp['text'],{icon:2,time:1000});
            }
        })
    }
    type_change();
    function type_change(){
        if($("#type").val()==1){
            $("#condition").attr("disabled",true);
            $("#condition").val(0);
        }else{
            $("#condition").removeAttr("disabled");
            $("#condition").val('');
        }
    }
    $("#type").change(function(){
        type_change();
    });
</script>
</body>
</html>