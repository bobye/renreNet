<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link href="wtb_styles/login.css" rel="stylesheet" type="text/css" /> 
</head>

<body>
<?php require_once './config.inc.php'; ?>
   <p>Only limited users can access this applet, see the <a href="demo.php">demo</a> (<a href="http://www.google.com/chrome/"><img src="image/chrome.png" /></a> ONLY)</p>
   <a  href="https://graph.renren.com/oauth/authorize?client_id=<?=$config->APPID?>&response_type=code&scope=<?=$config->scope?>&redirect_uri=<?=$config->redirecturi?>" ><img src="image/rr_login.png" class="vm" alt="人人连接登陆" /></a> 

   <p> WARNING: This applet works best when you have round 300 friends or less; if you have more than 500 friends, it may take some time to get the results; if you have more than 1000 friends, it may not get a good result automatically. You can interactively select a reasonable parameter in URL after first run, for <a href="http://jianbo.ws/blog/vcg/visualization-d3-for-renren/">details</a>.
   <p> <span style="color:#f00">UPDATE:</span>  Due to the <a href="http://dev.renren.com/blog/254">new policy</a>, this applet is no longer available to a REAL user, while I am not planning to submit it for verification.</p>
</p>

</body>
</html>
