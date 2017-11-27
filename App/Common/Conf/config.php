<?php
return array(
    //'配置项'=>'配置值'
    'DB_TYPE'           => 'mysql',     // 数据库类型
    'DB_HOST'           => 'localhost', // 服务器地址
    'DB_NAME'           => 'hw_tmls',          // 数据库名
    'DB_USER'           => 'xushuai',      // 用户名
    'DB_PWD'            => 'ilVJs43OXDkvHm3F',          // 密码
    'DB_PORT'           => '3306',    // 数据库表前缀
    'DB_DEBUG'          => true, // 数据库调试模式 开启后可以记录SQL日志
    'URL_MODEL'         => 2,
    'SITE_PATH'         => "http://shopceshi.sunday.so/",
    /* redis系统缓存 */
    'DATA_CACHE_TYPE'  => 'Redis',
    'REDIS_HOST'		  => '127.0.0.1',
    'REDIS_PORT'		  => 6379,
    'DATA_CACHE_TIME'	  => 120,
    'REDIS_KEY'         => "tmls",  //redis键前缀
    'REDIS_AUTH'        => "baimifan!@#",

    'KEFU'               => 'tmls',   //客服帐号前缀
    'CDN_PATH'          => "http://shopceshi.sunday.so/", //如果没有开启cdn，配置和SITE_PATH一样即可，否则出错
    'CDN_VERSION'       => '1.0.1',//cdn版本号

    'URL_MODULE_MAP'       => [
        'admin' => 'Admin',
        'index'  => 'Home',
    ],
);