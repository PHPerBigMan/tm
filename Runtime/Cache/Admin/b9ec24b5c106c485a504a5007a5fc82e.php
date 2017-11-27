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
    <form class="am-form am-form-horizontal" action="" method="post" id="from1">
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">管理员类型：</div>
            <div class="am-u-sm-9 am-u-md-3 am-u-end col-end">
                <select data-am-selected="{btnSize: 'sm'}" style="display: none;" name="group">
                    <?php if(is_array($group)): $i = 0; $__LIST__ = $group;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["gid"]) == $data["group"]): ?><option value="<?php echo ($vo["gid"]); ?>" selected><?php echo ($vo["title"]); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($vo["gid"]); ?>"><?php echo ($vo["title"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">
                管理员昵称
            </div>
            <div class="am-u-sm-8 am-u-md-4">
                <input type="text" class="am-input-sm" name="name" placeholder="请输入管理员昵称" value="<?php echo ($data["name"]); ?>">
            </div>
            <div class="am-hide-sm-only am-u-md-6"></div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">登录账号</div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                <input type="text" class="am-input-sm" name="account" placeholder="请输入登录账号" value="<?php echo ($data["account"]); ?>">
            </div>
        </div>

        <div class="am-g am-margin-top">
            <div class="am-u-sm-3 am-u-md-2 am-text-right">登录密码</div>
            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                <input type="text" class="am-input-sm" name="password" placeholder="请输入登录密码" value="<?php echo ($data["password"]); ?>">
            </div>
        </div>

        <div class="am-g am-margin-top-sm">
            <div class="am-u-sm-8 am-u-sm-offset-3">
                <?php if($data["id"] == '' ): ?><button type="button" class="am-btn am-btn-primary">添加管理员</button>
                    <?php else: ?>
                    <button type="button" class="am-btn am-btn-primary">修改管理员</button><?php endif; ?>
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
    $(".am-btn-primary").click(function () {
        $.post("/admin/Admin/handle",$("#from1").serialize(),function (data) {
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
    })
</script>
</body>
</html>