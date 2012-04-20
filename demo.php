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
      color: #666;	
      }
      #header p.right {
      float: right;
      }
      #header p.left {
      float: left;
      }
      #header a{
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
	<div id="header">
	<p class="left">Hint: place the mouse over the circle to display the name. </p>
	<p class="right">renreNet &copy; <a href="http://jianbo.ws/">bobye</a> | <a href="https://github.com/bobye/renreNet">code(v-1.0-preview)</a> | <a href="demo.php?uid=<?php echo $_GET['uid']; ?>">permanent link</a> <a href="http://www.google.com/chrome"><img src="image/chrome.png" /></a></p>
	<div class="clear"></div>
	</div>										      
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
        </script>
        <script src="force.js" type="text/javascript"></script> 
    </div>
  </body>
</html>
