<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="wtb_styles/login.css" rel="stylesheet" type="text/css" /> 
</head>

<body>
<?php require_once './config.inc.php'; ?>
<a  href="https://graph.renren.com/oauth/authorize?client_id=<?=$config->APPID?>&response_type=code&scope=<?=$config->scope?>&redirect_uri=<?=$config->redirecturi?>" ><img src="image/rr_login.png" class="vm" alt="人人连接登陆" /></a>


</body>
</html>