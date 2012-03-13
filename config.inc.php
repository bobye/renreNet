<?php

$config				= new stdClass;

$config->APIURL		= 'http://api.renren.com/restserver.do'; //RenRen网的API调用地址，不需要修改
$config->APPID		= '144374';	//你的API Key，请自行申请
$config->APIKey		= '2d648febc8704731adcd4cf8fbe1781c';	//你的API Key，请自行申请
$config->SecretKey	= 'debfc847416345cb91b5c6d6861e1c3a';	//你的API 密钥
$config->APIVersion	= '1.0';	//当前API的版本号，不需要修改
$config->decodeFormat	= 'json';	//默认的返回格式，根据实际情况修改，支持：json,xml

$config->redirecturi= 'http://127.0.0.1/~bobye/network/accesstoken.php';//你的获取code的回调地址，也是accesstoken的回调地址
$config->scope='photo_upload';
?>
