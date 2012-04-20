<?php
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <script type="text/javascript"  src="d3/d3.v2.js?2.9.0"></script>
    <style type="text/css">
      body {
      text-align:center;
      background: #ccc;
      }
      .gallery {
      background: #fff;
      }
      #content {
      margin:0px auto;
      width:980px;
      }
      #header {
      width: 980px;     
      color: #fff;	
text-align: left;
      }
      #footer {
      width: 980px;     
      color: #fff;	
text-align: right;
      }
      #footer a{
      color:#4A9DDF;
      }
.clear {
 clear:both;
 }
    </style>
  </head>
  <title>renreNet</title>
  <body>  
    <div id="content">
    <div id="header">Hint: place the mouse over circles to display their names.</div>
	<div class="gallery" id="chart"></div>
	<style type="text/css">
	  circle.node {
	  stroke: #fff;
	  stroke-width: 1.5px;
	  }
	  line.link {
	  stroke: #999;
	  stroke-opacity: .6;
	  }
	</style>
	<script type="text/javascript">
	    var json_data = "cache/"+"<?php if (isset($_GET['uid'])) echo 'd3i'.$_GET['uid'].'.json'; else echo 'demo.json'; ?>";
var edge_length = <?php if (isset($_GET['num'])) echo 20000 / (int) $_GET['num']; else echo 60; ?>;
var node_charge = <?php if (isset($_GET['num'])) echo -20000000 / (int) $_GET['num'] / (int) $_GET['num']; else echo -120; ?>;

if (node_charge < -200) { node_charge = -200; }
if (node_charge > -30) { node_charge = -30; }
if (edge_length > 80) { edge_length = 80; }
if (edge_length < 20) { edge_length = 20; }
//var edge_length = 60;
//var node_charge = -120;

        </script>
        <script src="force.js" type="text/javascript"></script> 
	<div id="footer">
	renreNet &copy; <a href="http://jianbo.ws/">bobye</a> | <a href="https://github.com/bobye/renreNet">code(v-1.0-preview)</a> | <a href="<?php echo curPageURL(); ?>">permanent link</a> <a href="http://www.google.com/chrome"><img src="image/chrome.png" /></a>
	<div class="clear"></div>
	</div>										      
    </div>
  </body>
</html>
