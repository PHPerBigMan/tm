<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script type="text/javascript" src="http://lib.h-ui.net/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <style>
        body{overflow-y: auto;font-size: 13px;}
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;">
    <form action="/admin/Carousel/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">轮播位置：</div>
            <div class="am-u-sm-9 am-u-md-3 am-u-end col-end">
                <select name="position" style="width: 240px">
                    <?php if(is_array($extend)): $i = 0; $__LIST__ = $extend;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["extendid"]) == $data["position"]): ?><option value="<?php echo ($vo["extendid"]); ?>" selected><?php echo ($vo["name"]); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($vo["extendid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">轮播标题</div>
            <div class="am-u-sm-8 am-u-md-8">
                <input type="hidden" name="carouselid" value="<?php echo ($data["carouselid"]); ?>">
                <input type="text" class="am-input-sm" name="title" placeholder="请输入轮播标题" value="<?php echo ($data["title"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">链接地址</div>
            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                <input type="text" class="am-input-sm" name="url" placeholder="请输入链接地址" value="<?php echo ($data["url"]); ?>">
            </div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">轮播图</div>
            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                <div class="am-form-group am-form-file">
                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                    <input id="doc-form-file" type="file" multiple name="suolvetu">
                </div>
                <div id="file-list"></div>
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
                <input type="hidden" value="<?php echo ($data["carouselimg"]); ?>" name="suo2">
                <?php if($data["carouselimg"] != ''): ?><img src="<?php echo ($data["carouselimg"]); ?>" width="80"><?php endif; ?>
                <script>
                    $(function() {
                        $('#doc-form-file').on('change', function() {
                            var fileNames = '';
                            $.each(this.files, function() {
                                fileNames += '<span class="am-badge">' + this.name + '</span> ';
                            });
                            $('#file-list').html(fileNames);
                        });
                    });
                </script>
            </div>
        </div>

        <div class="am-g am-margin-top-sm">
            <div class="am-u-sm-8 am-u-sm-offset-3">
                <?php if($data["carouselid"] == '' ): ?><button type="submit" class="am-btn am-btn-primary">添加轮播</button>
                    <?php else: ?>
                    <button type="submit" class="am-btn am-btn-primary">修改轮播</button><?php endif; ?>
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
<script>
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