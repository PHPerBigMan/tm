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
    <form action="/admin/Config/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">微信公众平台appid</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="appid" placeholder="请输入微信公众平台appid" value="<?php echo ($config["0"]["value"]); ?>" readonly>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">微信公众平台secret</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="password" class="am-input-sm" name="secret" placeholder="请输入微信公众平台secret" value="<?php echo ($config["1"]["value"]); ?>" readonly>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">微信公众平台token</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="token" placeholder="请输入微信公众平台token" value="<?php echo ($config["2"]["value"]); ?>" readonly>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">微信公众平台欢迎词</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="keyword" placeholder="请输入微信公众平台欢迎词" value="<?php echo ($config["3"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">微信支付key</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="password" class="am-input-sm" name="key" placeholder="请输入微信支付key" value="<?php echo ($config["4"]["value"]); ?>" readonly>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">微信支付商户号</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="password" class="am-input-sm" name="merchant_id" placeholder="请输入微信支付商户号" value="<?php echo ($config["5"]["value"]); ?>" readonly>
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">店铺名称</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="site_name" placeholder="请输入店铺名称" value="<?php echo ($config["8"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">店铺Logo</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="file" class="am-input-sm" name="site_logo" id="doc-form-file">
            </div>
            <div class="am-u-sm-8 am-u-md-9" id="file-list">
                <img src="<?php echo ($config["9"]["value"]); ?>" width="80">
            </div>
        </div>
        <script>
            var result = document.getElementById("file-list");
            var input = document.getElementById("doc-form-file");

            if(typeof FileReader==='undefined'){
                result.innerHTML = "抱歉，你的浏览器不支持 FileReader";
                input.setAttribute('disabled','disabled');
            }else{
                input.addEventListener('change',readFile,false);
            }
            function readFile(){
                var file = this.files[0];
                if(!/image\/\w+/.test(file.type)){
                    alert("文件必须为图片！");
                    return false;
                }
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    result.innerHTML = '<img src="'+this.result+'" alt="" width="90px" height="90px"/>'
                }
            }
        </script>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">店铺公告</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="notice" placeholder="请输入店铺公告" value="<?php echo ($config["10"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">客服电话</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="phone" placeholder="请输入客服电话" value="<?php echo ($config["11"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">银卡用户金额</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="silver" placeholder="请输入客服电话" value="<?php echo ($config["12"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">金卡用户金额</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="gold" placeholder="请输入客服电话" value="<?php echo ($config["13"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">至尊卡用户金额</div>
            <div class="am-u-sm-8 am-u-md-9">
                <input type="text" class="am-input-sm" name="extreme" placeholder="请输入客服电话" value="<?php echo ($config["14"]["value"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top-sm">
            <div class="am-u-sm-8 am-u-sm-offset-2">
                <button type="submit" class="am-btn am-btn-primary">修改配置</button>
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
<script src="//cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
<script type="text/javascript">
    $(function(){
        $("#form-admin-add").validate({
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                var index2 = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
                $(form).ajaxSubmit(function (data) {
                    layer.close(index2);
                    $r = $.parseJSON(data);
                    if($r['status'] == "200"){
                        layer.msg($r['text'],function () {
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