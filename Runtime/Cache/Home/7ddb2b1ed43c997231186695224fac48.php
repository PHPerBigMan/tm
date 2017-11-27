<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" style="width: 100%;height: 100%;">
<head>
    <meta charset="UTF-8">
    <title>我的专属推广海报</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="<?php echo C('CDN_PATH');?>/Public/resource/css/hindex.css?<?php echo C('CDN_VERSION');?>">
    <style>
        .first{width: 100%;height: 100%;background: url(/Public/resource/images/tgy.png);background-size: cover;margin: 0px auto;position: fixed}
        .sec{top: 28px;left: 100px;}
        .code{background: white;width:92px;padding: 10px;box-shadow: 0 0 5px rgba(142,142,142,1);position: absolute;bottom: 0px;left: 8px;}
    </style>
</head>
<body style="width: 100%;height: 100%;margin: 0px;">
<!--<?php echo ($user["nickname"]); ?>-->
<div class="first">
    <span style="color: #fff;position: absolute;" class="sec"></span>
</div>

<div class="code">
    <img src="<?php echo C('SITE_PATH');?>Home/user/code?url=<?php echo ($url); ?>&id=<?php echo ($user["id"]); ?>" width="92" height="92">
</div>
<!--<img src="/Public/resource/images/tgimage_bg3.jpg" style="max-width: 100%">-->
</body>
</html>