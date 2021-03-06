<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <script src="//cdn.bootcss.com/jquery/2.0.2/jquery.min.js"></script>
    <link rel="stylesheet" href="/Public/resource/assets/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/Public/resource/assets/css/admin.css">
    <style>
        html{overflow-y: scroll}
        body{overflow-y: scroll;font-size: 13px;}
        .lbimg{margin-bottom:20px}
        .valbox{width: 100%;height: 110px;background: #f8f8f8;padding: 20px;margin: 10px 0px;}
        .valbox span {
            display: inline-block;
            border: 1px solid #e5e5e5;
            padding: 2px 8px;
            margin-top: 10px;
            border-radius: 4px;
            background: #fff;
            margin-right: 10px;
            position: relative;
        }
        .valbox span i.closed2 {
            font-style: normal;
            position: absolute;
            top: -5px;
            right: -5px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            width: 10px;
            height: 10px;
            font-size: 10px;
            text-align: center;
            line-height: 10px;
            cursor: pointer;
        }
        .tjjbox a{cursor: pointer}
        .closed {
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            display: inline-block;
            float: right;
            font-style: normal;
            font-size: 12px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="hw-content" style="padding: 20px;padding-bottom: 50px;">
    <form action="/admin/CommodityJifen/handle" method="post" class="am-form" id="form-admin-add" enctype="multipart/form-data">
    <div class="am-tabs am-margin" data-am-tabs="">
        <ul class="am-tabs-nav am-nav am-nav-tabs">
            <li class="am-active"><a href="#tab1">基本信息</a></li>
            <li class=""><a href="#tab2">图文详情</a></li>
            <li class=""><a href="#tab3">轮播图</a></li>
            <li class=""><a href="#tab4">商品规格</a></li>
        </ul>

        <div class="am-tabs-bd" style="touch-action: pan-y; -webkit-user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
            <div class="am-tab-panel am-fade am-active am-in" id="tab1">
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            商品标题：
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="hidden" value="<?php echo ($commodity["commodityid"]); ?>" name="commodityid">
                            <input type="text" class="am-input-sm" name="title" value="<?php echo ($commodity["title"]); ?>">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            平台货号：
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="huohao" value="<?php echo ($commodity["huohao"]); ?>">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">注：可以和淘宝相同，方便管理</div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            兑换所需积分：
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="current" value="<?php echo ($commodity["current"]); ?>">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6"></div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            初始兑换量：
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="sales" value="<?php echo ($commodity["sales"]); ?>">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">注：初始化该商品的兑换量</div>
                    </div>
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            运费模版：
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <select name="carriageid" class="form-control">
                                <option value="0">请选择运费模板</option>
                                <?php if(is_array($carriage)): $i = 0; $__LIST__ = $carriage;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo["carriageid"]) == $commodity["carriageid"]): ?><option value="<?php echo ($vo["carriageid"]); ?>" selected><?php echo ($vo["title"]); ?></option>
                                        <?php else: ?>
                                        <option value="<?php echo ($vo["carriageid"]); ?>"><?php echo ($vo["title"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">注：该商品的运费将根据该模版自动计算运费</div>
                    </div>
                    <div class="am-g am-margin-top-sm">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            缩略图：
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end">
                            <div class="am-form-group am-form-file">
                                <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                    <i class="am-icon-cloud-upload"></i> 选择要上传的文件</button>
                                <input id="doc-form-file" type="file" multiple name="suolvetu[]">
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
                            <input type="hidden" value="<?php echo ($commodity["thumbnail"]); ?>" name="suo2">
                            <img src="<?php echo ($commodity["thumbnail"]); ?>" width="80">
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
            </div>

            <div class="am-tab-panel am-fade" id="tab2">
                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-12 am-u-md-12">
                            <script id="content" type="text/plain" style="width:100%;height:400px;"><?php echo (htmlspecialchars_decode($commodity["content"])); ?></script>
                        </div>
                        <style>
                            .edui-container,#content{width: 100% !important;}
                        </style>
                        <div class="am-hide-sm-only am-u-md-6"></div>
                    </div>
            </div>

            <div class="am-tab-panel am-fade" id="tab3">
                    <div class="am-g am-margin-top-sm">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            <button type="button" class="am-btn am-btn-success" @click="addimg">添加相册</button>
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end">
                            <p class="cp1" v-for="item in carousel">
                                <img :src="item" width="80">
                                <input type="hidden" value="{{ item }}" name="xcimg[]">
                                <a class="btn btn-danger radius" @click="del(this)">删除</a>
                            <p>
                            <template v-for="input in inputimg">
                            <input type="file" class="lbimg" name="lunbo[]">
                            </template>
                        </div>
                    </div>
            </div>
            <div class="am-tab-panel am-fade" id="tab4">
                <div class="am-g am-margin-top">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">选择规格</div>
                    <div class="am-u-sm-8 am-u-md-10">
                        <div class="tjjbox">
                            <a class="btn2" @click="addxiangmu">添加规格</a>
                        </div>
                        <div class="valbox" v-for="(mykey,item) in data">
                            <select class="form-control" style="width: 140px;display: inline-block" v-model="item.attr">
                                <option value="0">请选择规格</option>
                                <?php if(is_array($guige)): $i = 0; $__LIST__ = $guige;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                            <button type="button" class="am-btn am-btn-warning" @click="addval(mykey,this)">添加属性</button>
                            <i class="closed" @click="removeall(mykey,this)">X</i>
                            <div style="clear: both"></div>
                            <p>
                                <template v-for="(i,v) in item.val">
                                <span><i class="closed2" @click="delval(i,this,mykey)">X</i><b>{{ v }}</b></span>
                                </template>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="am-g am-margin-top">
                    <div class="am-u-sm-4 am-u-md-2 am-text-right">商品库存</div>
                    <div class="am-u-sm-8 am-u-md-10">
                        <style>
                            .am-table input[type='text']{height: 30px;}
                        </style>
                        <table class="am-table am-table-bordered" >
                            <thead>
                                <tr>
                                    <template v-for="(i,v) in data" v-if="v.attr != '0' && v.val!='' ">
                                    <th width="150">{{ v.attr }}</th>
                                    </template>
                                    <th width="150">所需积分</th>
                                    <th width="150">库存（件）</th>
                                    <th width="150">sku编码（条形码）</th>
                                </tr>
                                <input type="hidden" value="{{ jsonstr }}" name="shuxingji">
                            </thead>
                            <tbody>
                            <template v-for="(n,value) in arr" v-if="arr.length > 0">
                                <tr>
                                    <template v-for="val in value">
                                        <td>{{ val }}</td>
                                    </template>
                                    <input type="hidden" name="shuxingzhi[]" value="{{ arr[n].join(',')}}">
                                    <td><input type="text" value="{{ editdata[n].attr_money }}" name="sku_price[]"></td>
                                    <td><input type="text" value="{{ editdata[n].stock }}" name="sku_profit[]"></td>
                                    <td><input type="text" value="{{ editdata[n].bianma }}" name="sku_bianma[]"></td>
                                </tbody>
                            </template>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="am-margin">
        <button type="submit" class="am-btn am-btn-primary am-btn-xs">提交保存</button>
    </div>
    </form>
</div>
<script src="http://cdn.bootcss.com/vue/1.0.26/vue.min.js"></script>
<!--[if lt IE 9]>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/Public/resource/assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="/Public/resource/layer/layer.js"></script>
<script src="/Public/resource/layer/laydate.js"></script>
<script src="/Public/resource/assets/js/amazeui.min.js"></script>
<script src="/Public/resource/assets/js/hw-layer.js"></script>
<script src="/Public/resource/assets/js/app.js"></script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/ueditor.parse.min.js"> </script>
<script type="text/javascript" src="/Public/resource/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="http://lib.h-ui.net/jquery.validation/1.14.0/validate-methods.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.min.js"></script>
<script type="text/javascript">
    $(function(){
        var ue = UE.getEditor('content');

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
<script>
    var vm = new Vue({
        el: 'body',
        data: {
            isclass:<?php echo ((isset($commodity["classifyid"]) && ($commodity["classifyid"] !== ""))?($commodity["classifyid"]):'0'); ?>,
            classify:<?php echo (json_encode($classify)); ?>,
            data : <?php echo ((isset($extend[0]['shuxingji']) && ($extend[0]['shuxingji'] !== ""))?($extend[0]['shuxingji']):'[]'); ?>,
            arr : [],
            editdata : <?php echo (json_encode($extend)); ?>,
            jsonstr : '',
            inputimg : 0,
            goodsnub :0,
            carousel : [],
            goods : [],
            carousel:<?php echo ((isset($commodity["carrousel"]) && ($commodity["carrousel"] !== ""))?($commodity["carrousel"]):"[]"); ?>,
        },created: function () {
            // `this` 指向 vm 实例
            if(this.data.length>0){
                var temparr = []
                for($i= 0 ; $i<this.data.length;$i++){
                    temparr.push(this.data[$i].val)
                }
                var ret = doExchange(temparr);
                for (var i = 0; i < ret.length; i++) {
                    this.arr.push(ret[i].split(","))
                }
                this.jsonstr = JSON.stringify(transform(this.data));
            }
        },watch:{
            data:function(val,oldVal){
                this.jsonstr = JSON.stringify(transform(val));
            }
        },
        methods: {
            addxiangmu:function () {
                vm.data.push({attr:'',val:[]});
            },
            removeall:function (id,event) {
                this.data.splice(id, 1);
                doset()
            },
            addval:function (id,event) {
                if(vm.data[event.$index].attr == 0){
                    layer.msg('请先选择规格！');
                    return
                }
                layer.prompt({
                    title: '输入属性值',
                    formType: 0 //prompt风格，支持0-2
                }, function(pass){
                    vm.data[id].val.push(pass);
                    layer.msg('添加成功！');
                    doset()
                });
            },
            delval:function (id,event,aid) {
                this.data[aid].val.splice(id, 1);
                doset()
            },
            addimg: function (event) {
                vm.inputimg = vm.inputimg + 1;
            },
            del: function (event) {
                vm.carousel.$remove(vm.carousel[event.$index])
            },
        }
    })

    function doset() {
        var temparr = []
        vm.arr = []
        vm.editdata = []
        for($i= 0 ; $i<vm.data.length;$i++){
            if(vm.data[$i].val.length>0){
                temparr.push(vm.data[$i].val)
            }
        }
        var ret = doExchange(temparr);
        for (var i = 0; i < ret.length; i++) {
            vm.arr.push(ret[i].split(","))
        }
        vm.jsonstr = JSON.stringify(transform(vm.data));
    }


    /**
     * 对象转数组
     * @param obj
     * @returns {Array}
     */
    function transform(obj){
        var arr = [];
        for(var item in obj){
            arr.push(obj[item]);
        }
        return arr;
    }


    function doExchange(doubleArrays){
        var len=doubleArrays.length;
        if(len>=2){
            var len1=doubleArrays[0].length;
            var len2=doubleArrays[1].length;
            var newlen=len1*len2;
            var temp=new Array(newlen);
            var index=0;
            for(var i=0;i<len1;i++){
                for(var j=0;j<len2;j++){
                    temp[index]=doubleArrays[0][i]+","+
                            doubleArrays[1][j];
                    index++;
                }
            }
            var newArray=new Array(len-1);
            for(var i=2;i<len;i++){
                newArray[i-1]= doubleArrays[i];
            }
            newArray[0]=temp;
            return doExchange(newArray);
        }
        else{
            return doubleArrays[0];
        }
    }
</script>
</body>
</html>