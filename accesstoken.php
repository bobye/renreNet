<?php

require_once './config.inc.php';
@header('Pragma:no-cache');
@header('Cache-Control:no-cache');
$code = empty($_GET['code']) ? null : $_GET['code'];
if(null !== $code) {
  //take access
  $grant_type = 'authorization_code';
  $client_id = $config->APIKey;
  $client_secret = $config->SecretKey;
  $redirect_uri = $config->redirecturi;
  //$url = "https://graph.renren.com/oauth/token?client_id={$client_id}&client_secret={$client_secret}&redirect_uri={$redirect_uri}&grant_type={$grant_type}&code={$code}";
  $url = "https://graph.renren.com/oauth/token?redirect_uri=".$redirect_uri."&grant_type=".$grant_type."&code=".$code;
  $params = array(
		  'client_id' => $client_id,
		  'client_secret' => $client_secret,
		  );
  $ret = http($url, 'POST', $params);
  $ret = json_decode($ret, true);
  //var_dump($ret); echo '<hr>';
  $access_token = $ret['access_token'];
  //echo "access taken!";
  

  //take session
  $url = "https://graph.renren.com/renren_api/session_key?oauth_token=".$access_token;
  $ret = http($url, 'GET');
  $ret = json_decode($ret, true);
  //var_dump($ret); echo '<hr>';
  $session_key = $ret['renren_token']['session_key'];
  //echo "session started!";

  //test API
  $url = 'http://api.renren.com/restserver.do';  
  $params = array(
		  'api_key' => $config->APIKey,
		  'call_id' => array_pop(explode(' ', microtime())), //当前调用请求队列号，建议使用当前系统时间的毫秒值。
		  'count' => 2000,
		  'format' => 'json',
		  'method' => 'friends.get',
		  'page' => 1,
		  'session_key' => $session_key,
		  'v' => '1.0',
		  );
  ksort($params);
  $params['sig'] = getSig($params, $config->SecretKey);
  
  $ret = http($url, 'POST', $params);
  //echo $ret; echo '<hr>';

  $friends = json_decode($ret, true);
  //var_dump($friends); echo '<hr>';
  
  $count_friends = count($friends);
  //echo $count_friends;

  for ($counter=1; $counter < $count_friends; $counter +=1) {
    $buffer_uids_cols = implode(',',array_fill(0,$count_friends - $counter, $friends[$counter-1]));
    $buffer_uids_rows = implode(',',array_slice($friends,$counter,$count_friends - $counter ));
    if (isset($uids_cols)||isset($uids_rows)) {
      $uids_cols = $uids_cols.','.$buffer_uids_cols;
      $uids_rows = $uids_rows.','.$buffer_uids_rows;
    }else{
      $uids_cols = $buffer_uids_cols;
      $uids_rows = $buffer_uids_rows;
    }
  }

  //  echo $uids_cols; echo '<hr>';
  //  echo $uids_rows; echo '<hr>';

  $params = array(
  		  'api_key' => $config->APIKey,
  		  'call_id' => array_pop(explode(' ', microtime())), //当前调用请求队列号，建议使用当前系统时间的毫秒值。
  		  'format' => 'json',
  		  'method' => 'friends.areFriends',
  		  'session_key' => $session_key,
  		  'v' => '1.0',
  		  'uids1' => $uids_cols,
  		  'uids2' => $uids_rows,
  		  );
  ksort($params);
  $params['sig'] = getSig($params, $config->SecretKey);
  
  $ret = http($url, 'POST', $params);

  $relationships = json_decode($ret, true);
  //$relationships = json_decode('[{"are_friends":0,"uid2":42998847,"uid1":32015768},{"are_friends":0,"uid2":48774601,"uid1":32015768},{"are_friends":0,"uid2":95563710,"uid1":32015768},{"are_friends":0,"uid2":179706788,"uid1":32015768}]',true);
  
  echo $ret; echo '<hr>';
  //var_dump($relationships);

  $file2wrt = 'cache/tmp.edges';
  $fp = fopen($file2wrt,'w+');
  
  $count_edges = count($relationships);

  for ($counter=0; $counter < $count_edges; $counter += 1)
    if ($relationships[$counter]['are_friends'] == '1')
      fwrite($fp, $relationships[$counter]['uid1'].'\t'.$relationships[$counter]['uid2']."\n");
    else
      echo $relationships[$counter]['are_friends'];
  
  fclose($fp);
  echo "success!";
}

function getSig($params, $oauth_consumer_token_secret) {
  array_walk($params, 'concatParams');
  $params = array_values($params);
  sort($params);
  $sig = implode('', $params);
  $sig .= $oauth_consumer_token_secret;
  return md5($sig);
}

function concatParams(&$val, $key) {
	$val = "{$key}={$val}";
}

function http($url, $method, $postfields = array(), $multi = false){
  $urlArr = parse_url($url);
  //check https
  $version = '1.1';
  $host = $header_host = isset($urlArr['host']) ? $urlArr['host'] : '';
  if('https' === strtolower($urlArr['scheme'])) {
    $port = (isset($urlArr['port']) && '443' !== $urlArr['port']) ? $urlArr['port'] : '443';
    $host = "ssl://{$host}";
  } else {
    $port = (isset($urlArr['port']) && '80' !== $urlArr['port']) ? $urlArr['port'] : '80';
  }
	
  $requestPath = $urlArr['path'];
  if(isset($urlArr['query'])) $requestPath .= "?{$urlArr['query']}";

  $header = "{$method} {$requestPath} HTTP/{$version}\r\n";
  $header .= "Host: {$header_host}\r\n";
  if('post' === strtolower($method)) {
    //handle $postfields
    $postfieldsStr = '';
    if($multi) {
      $boundary = "---------------------------".substr(md5(rand(0,32000)),0,10);
      $header .= "Content-Type: multipart/form-data; boundary={$boundary}\r\n";
      foreach($postfields as $key => $val) {
	$postfieldsStr .= "--{$boundary}\r\n";
	if(is_file($val) && file_exists($val)) {
	  $postfieldsStr .= "Content-Disposition: form-data; name=\"{$key}\"; filename=\"" . basename($val) . "\"\r\n";
	  $postfieldsStr .= "Content-Type: " . getMimeType($val) . "\r\n\r\n";
	  $postfieldsStr .= file_get_contents($val) . "\r\n";
	} else {
	  $postfieldsStr .= "Content-Disposition: form-data; name=\"{$key}\"\r\n\r\n";
	  $postfieldsStr .= "{$val}\r\n";
	}
      }
			
      $postfieldsStr .= "--{$boundary}--\r\n";
    } else {
      $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
      foreach($postfields as $key => $val) {
	$postfieldsStr .= urlencode($key) . '=' . urlencode($val) . '&';
      }
      $postfieldsStr = substr($postfieldsStr, 0, -1);
    }
		
    $header .= "Content-Length: ".strlen($postfieldsStr)."\r\n";
    $header .= "Connection: Close\r\n\r\n";
    $header .= $postfieldsStr;
  } else {
    $header .= "Connection: Close\r\n\r\n";
  }

  $ret = '';
	
  $fp = fsockopen($host,$port,$errno,$errstr,30);

  if(!$fp) {
    throw new Exception('open socket fail');
  } else {
    fwrite($fp, $header);
    while(!feof($fp)) {
      $ret .= fgets($fp, 4096);
    }
    fclose($fp);
    if(false !== strrpos($ret,'Transfer-Encoding: chunked')){
      $info = explode("\r\n\r\n",$ret);
      $response = explode("\r\n",$info[1]);
      $t = array_slice($response,1,-1);

      $returnInfo = implode('',$t);
    }else{
      $response = explode("\r\n\r\n",$ret);
      $returnInfo = $response[1];
    }
		
    return $returnInfo;
  }
}

function getMimeType($filename) {
  $mime_types = array(
		      'txt' => 'text/plain',
		      'htm' => 'text/html',
		      'html' => 'text/html',
		      'php' => 'text/html',
		      'css' => 'text/css',
		      'js' => 'application/javascript',
		      'json' => 'application/json',
		      'xml' => 'application/xml',
		      'swf' => 'application/x-shockwave-flash',
		      'flv' => 'video/x-flv',
		
		      // images
		      'png' => 'image/png',
		      'jpe' => 'image/jpeg',
		      'jpeg' => 'image/jpeg',
		      'jpg' => 'image/jpeg',
		      'gif' => 'image/gif',
		      'bmp' => 'image/bmp',
		      'ico' => 'image/vnd.microsoft.icon',
		      'tiff' => 'image/tiff',
		      'tif' => 'image/tiff',
		      'svg' => 'image/svg+xml',
		      'svgz' => 'image/svg+xml',
		
		      // archives
		      'zip' => 'application/zip',
		      'rar' => 'application/x-rar-compressed',
		      'exe' => 'application/x-msdownload',
		      'msi' => 'application/x-msdownload',
		      'cab' => 'application/vnd.ms-cab-compressed',
		
		      // audio/video
		      'mp3' => 'audio/mpeg',
		      'qt' => 'video/quicktime',
		      'mov' => 'video/quicktime',
		
		      // adobe
		      'pdf' => 'application/pdf',
		      'psd' => 'image/vnd.adobe.photoshop',
		      'ai' => 'application/postscript',
		      'eps' => 'application/postscript',
		      'ps' => 'application/postscript',
		
		      // ms office
		      'doc' => 'application/msword',
		      'rtf' => 'application/rtf',
		      'xls' => 'application/vnd.ms-excel',
		      'ppt' => 'application/vnd.ms-powerpoint',
		
		      // open office
		      'odt' => 'application/vnd.oasis.opendocument.text',
		      'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
		      );
	
  $ext = strtolower(array_pop(explode('.',$filename)));
  if (array_key_exists($ext, $mime_types)) {
    return $mime_types[$ext];
  } elseif (function_exists('finfo_open')) {
    $finfo = finfo_open(FILEINFO_MIME);
    $mimetype = finfo_file($finfo, $filename);
    finfo_close($finfo);
    return $mimetype;
  } else {
    return 'application/octet-stream';
  }
}
?>
