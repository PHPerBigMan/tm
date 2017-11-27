<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="//cdn.bootcss.com/jquery/2.0.2/jquery.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <style>
        body{overflow-y: auto;font-size: 13px;}
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;">
    <form action="/admin/Order/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">收货人：</div>
            <div class="am-u-sm-8 am-u-md-10">
                <input type="hidden" name="extendid" value="<?php echo ($data["extend"]["extendid"]); ?>">
                <input type="hidden" name="orderid" value="<?php echo $_GET['id'];?>">
                <input type="hidden" name="addjson" value="<?php echo (htmlspecialchars(json_encode($data["address"]))); ?>">
                <?php echo ($data["address"]["name"]); ?>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">联系电话：</div>
            <div class="am-u-sm-8 am-u-md-10">
                <?php echo ($data["address"]["phone"]); ?>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">详细地址：</div>
            <div class="am-u-sm-8 am-u-md-10">
                <?php echo ($data["address"]["province"]); echo ($data["address"]["address"]); ?>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">物流公司：</div>
            <div class="am-u-sm-8 am-u-md-10">
                <select name="express" class="form-control valid" aria-invalid="false" id="gongsi">
                    <option value="申通快递" <?php if(($data["extend"]["express"]) == "申通快递"): ?>selected<?php endif; ?>>申通快递</option>
                    <option value="EMS" <?php if(($data["extend"]["express"]) == "EMS"): ?>selected<?php endif; ?>>EMS</option>
                    <option value="顺丰快递" <?php if(($data["extend"]["express"]) == "顺丰快递"): ?>selected<?php endif; ?>>顺丰快递</option>
                    <option value="圆通快递" <?php if(($data["extend"]["express"]) == "圆通快递"): ?>selected<?php endif; ?>>圆通快递</option>
                    <option value="中通快递" <?php if(($data["extend"]["express"]) == "中通快递"): ?>selected<?php endif; ?>>中通快递</option>
                </select>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">物流单号：</div>
            <div class="am-u-sm-8 am-u-md-10">
                <input type="text" class="am-input-sm" name="couriernumber" placeholder="请输入单号" value="<?php echo ($data["extend"]["couriernumber"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top-sm">
            <div class="am-u-sm-8 am-u-sm-offset-3">
                <button type="submit" class="am-btn am-btn-primary">确认发货</button>
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
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/validate-methods.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#form-admin-add").validate({
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit(function (data) {
                    if($("#gongsi").val() == 0){
                        layer.msg("请先选择物流公司！",function () {
                            return
                        });
                        return 0;
                    }
                    var index2 = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                    layer.close(index2);
                    $r = $.parseJSON(data);
                    if($r['status'] == "200"){
                        layer.msg($r['text'],function () {
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.location.reload()
                            parent.layer.close(index);
                        });
                    }else{
                        layer.msg($r['text']);
                    }
                });
            }
        });
    });
</script>
</body>
</html>