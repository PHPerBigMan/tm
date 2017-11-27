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
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;">
    <form action="/admin/Classify/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">

        <?php if($data["classifyid"] == '' ): ?><div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">上级分类</div>
            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                <select name="pid" class="form-control valid" aria-invalid="false" style="height: 35px;font-size: 13px">
                    <option value="0">顶级分类</option>
                    <template v-for="item in classify">
                        <option value="{{ item.classifyid }}" v-if="item.level == 1">{{ item.name }}</option>
                        <option value="{{ item.classifyid }}" v-if="item.level == 2">|--------{{ item.name }}</option>
                        <option value="{{ item.classifyid }}" v-if="item.level == 3">|----------------{{ item.name }}</option>
                    </template>
                </select>
            </div>
        </div><?php endif; ?>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">分类名称</div>
            <div class="am-u-sm-8 am-u-md-8">
                <input type="hidden" name="classifyid" value="<?php echo ($data["classifyid"]); ?>">
                <input type="text" class="am-input-sm" name="name" autocomplete="off" placeholder="请输入轮播标题" value="<?php echo ($data["name"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">分类排序</div>
            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                <input type="text" class="am-input-sm" name="sort" autocomplete="off" placeholder="显示序列" value="<?php echo ($data["sort"]); ?>">
            </div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">是否显示</div>
            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                <select name="isshow" class="form-control valid" aria-invalid="false" style="height: 35px;font-size: 13px" v-model="isshow">
                    <option value="1">是</option>
                    <option value="0">否</option>
                </select>
            </div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">分类图标</div>
            <div class="am-u-sm-8 am-u-md-8 am-u-end col-end">
                <div class="am-form-group am-form-file">
                    <button type="button" class="am-btn am-btn-danger am-btn-sm">
                        <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                    <input id="doc-form-file" type="file" multiple name="suolvetu">
                </div>
                <div id="file-list"></div>
                <input type="hidden" value="<?php echo ($data["ico"]); ?>" name="suo2">
                <?php if($data["ico"] != ''): ?><img src="<?php echo ($data["ico"]); ?>" width="80"><?php endif; ?>
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
                <?php if($data["classifyid"] == '' ): ?><button type="submit" class="am-btn am-btn-primary">添加分类</button>
                    <?php else: ?>
                    <button type="submit" class="am-btn am-btn-primary">修改分类</button><?php endif; ?>
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
    var vm = new Vue({
        el: 'body',
        data: {
            classify:<?php echo (json_encode($classify)); ?>,
            data:<?php echo (json_encode($data)); ?>,
            isshow:<?php echo ((isset($data["isshow"]) && ($data["isshow"] !== ""))?($data["isshow"]):'0'); ?>,
        }
    })

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