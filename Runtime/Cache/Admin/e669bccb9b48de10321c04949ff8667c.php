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
    <form action="/admin/Article/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">文章标题</div>
            <div class="am-u-sm-8 am-u-md-10">
                <input type="hidden" name="articleid" value="<?php echo ($data["articleid"]); ?>">
                <input type="text" class="am-input-sm" name="title" placeholder="请输入文章标题" value="<?php echo ($data["title"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">内容</div>
            <div class="am-u-sm-8 am-u-md-10">
                <script id="content" type="text/plain" style="width:100%;height:400px;" name="content"><?php echo (htmlspecialchars_decode($data["content"])); ?></script>
            </div>
            <style>
                .edui-container,#content{width: 100% !important;}
            </style>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top-sm">
            <div class="am-u-sm-8 am-u-sm-offset-2">
                <button type="submit" class="am-btn am-btn-primary">修改文章</button>
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
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.parse.min.js"> </script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/validate-methods.js"></script>
<script src="//cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
<script type="text/javascript">
    $(function(){
        var ue = UE.getEditor('content');
    });
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