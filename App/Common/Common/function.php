<?php

    function retJson($status,$text){
    	if(is_not_json($text)){
    		$c =  '{"status":"'.$status.'","text":"'.$text.'"}';
    	}else{
    		$c =  '{"status":"'.$status.'","text":'.$text.'}';
    	}

        exit($c);
    }

    function is_not_json($str){
	    return is_null(json_decode($str));
	}


    /**
     * [arraySortByKey 数组重新索引]
     * @param  array   $array [description]
     * @param  [type]  $key   [description]
     * @param  boolean $asc   [description]
     * @return [type]         [description]
     */
    function arraySortByKey(array $array, $key, $asc = true){
        $result = array();
        // 整理出准备排序的数组
        foreach ( $array as $k => &$v ) {
            $values[$k] = isset($v[$key]) ? $v[$key] : '';
        }
        unset($v);
        // 对需要排序键值进行排序
        $asc ? asort($values) : arsort($values);
        // 重新排列原有数组
        foreach ( $values as $k => $v ) {
            $result[$k] = $array[$k];
        }
      return $result;
    }

    /**
     * 获取某一时间段内所有日期
     */
    function get_all_day($end,$start){
        $days = (strtotime($end)-strtotime($start))/3600/24;
        $start_day = $start;
        $arr=array();
        for($i=0;$i<$days;$i++)
        {
            $arr[]=date('Y-m-d',strtotime($start_day)+$i*24*60*60);
        }
        return $arr;
    }


    /**
     * 开发者：huangwei
     * 方法功能：上传图片
     */
    function upload($width="500"){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath  =      ''; // 设置附件上传目录    // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            return $upload->getError();
        }else{// 上传成功

            foreach($info as $file){
                yasuo('Uploads/'.$file['savepath'].$file['savename'],$width);
            }
            return $info;
        }
    }

    /**
     * 开发者：huangwei
     * 方法功能：对上传图片进行压缩并裁剪至500px宽
     * @param $path
     */
    function yasuo($path,$set){
        $image = new \Think\Image();
        $image->open($path);
        $height = $image->height();
        $width = $image->width(); // 返回图片的宽度
        if($width<=$set){
            $height = 0;
        }else{
            $width = $width/$set; //取得图片的长宽比
            $height = ceil($height/$width);
        }
        $image->thumb($set,$height)->save($path);
    }

    /**
     * 开发者：huangwei
     * 方法功能：生产短链接
     * @param $surl
     *
     * @return mixed
     */
    function get_duan_url($surl){
        $ch = curl_init();
        $url = 'http://apis.baidu.com/3023/shorturl/shorten?url_long='.urlencode($surl);
        $header = array(
            'apikey: 28ed820c8b04b7e623fe8a9fe9812ed2',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        $res = json_decode($res,true);
        return $res['urls'][0]['url_short'];
    }


    function downloadweixinfile($url){
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_NOBODY,0);
        curl_setopt($ch, CURLOPT_TIMEOUT,60);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $package = curl_exec($ch);
        $curl_errno = curl_errno($ch);
        $httpinfo = curl_getinfo($ch);
        curl_close($ch);
        if($curl_errno >0){
            return "404";
        }
        return $package;
    }

    function saveweixinfile($filename,$filecontent){
        $local_file = fopen($filename,'w');
        if(false !== $local_file){
            if(false !== fwrite($local_file,$filecontent)){
                fclose($local_file);
            }
        }
    }

    function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
    {
        $pic_width = imagesx($im);
        $pic_height = imagesy($im);

        if(($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight))
        {
            if($maxwidth && $pic_width>$maxwidth)
            {
                $widthratio = $maxwidth/$pic_width;
                $resizewidth_tag = true;
            }

            if($maxheight && $pic_height>$maxheight)
            {
                $heightratio = $maxheight/$pic_height;
                $resizeheight_tag = true;
            }

            if($resizewidth_tag && $resizeheight_tag)
            {
                if($widthratio<$heightratio)
                    $ratio = $widthratio;
                else
                    $ratio = $heightratio;
            }

            if($resizewidth_tag && !$resizeheight_tag)
                $ratio = $widthratio;
            if($resizeheight_tag && !$resizewidth_tag)
                $ratio = $heightratio;

            $newwidth = $pic_width * $ratio;
            $newheight = $pic_height * $ratio;

            if(function_exists("imagecopyresampled"))
            {
                $newim = imagecreatetruecolor($newwidth,$newheight);//PHP系统函数
                imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);//PHP系统函数
            }
            else
            {
                $newim = imagecreate($newwidth,$newheight);
                imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
            }

            $name = $name.$filetype;
            imagejpeg($newim,$name);
            imagedestroy($newim);
        }
        else
        {
            $name = $name.$filetype;
            imagejpeg($im,$name);
        }
    }

/**
 *生成优惠券
 */
function getCouponImage($info,$path){
    $image = new \Think\Image();
    $date = date("Y.m.d",$info["starttime"])."-".date("Y.m.d",$info["endtime"]);
    $size = 40;
    $height = 52;
    if($info["facevalue"]<=9){
        $size = 40;
        $height = 52;
    }elseif($info["facevalue"]<=99){
        $size = 35;
        $height = 57;
    }elseif($info["facevalue"]<=999){
        $size = 30;
        $height = 62;
    }
    switch ($info["type"]){
        case 1:
            $image->open("./Public/resource/images/image_youhui1.png");//打开背景图片
            $image->text("无门槛抵用券","./Public/resource/font/msyhl.ttc",15,"#DCF5B1",array(63,75));
            $image->text($date,"./Public/resource/font/msyhl.ttc",12,"#DCF5B1",array(63,125));
            $image->text($info["facevalue"],"./Public/resource/font/msyh.ttc",$size,"#ffffff",array(390,$height));
            break;
        case 2:
            $image->open("./Public/resource/images/image_youhui2.png");//打开背景图片
            $image->text("消费满".$info["condition"]."元减".$info["facevalue"]."元","./Public/resource/font/msyhl.ttc",15,"#6E4603",array(63,75));
            $image->text($date,"./Public/resource/font/msyhl.ttc",12,"#968227",array(63,125));
            $image->text($info["facevalue"],"./Public/resource/font/msyh.ttc",$size,"#8F7B1E",array(390,$height));
            break;
    }
    $image->save($path);
    return $path;
}