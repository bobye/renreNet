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
      #footer {
      margin:0px auto;
      width: 980px;
      color: #fff;
      text-align: right;
      }
      #footer a{
      color:#4A9DDF;
      }
    </style>
  </head>
  <title>renreNet</title>
  <body>  
    <div id="content">
      <div class="gallery" id="chart">
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
	    var json_data = "cache/d3i"+ "<?php echo $_GET['uid'].'.json' ?>";
</script>
<script src="force.js" type="text/javascript"></script> 
      </div>
    </div>
    <div id="footer">renreNet &copy; <a href="http://jianbo.ws/">bobye</a> | <a href="https://github.com/bobye/renreNet">code(v-1.0-preview)</a> | <a href="demo.php?uid=<?php echo $_GET['uid']; ?>">permanent links</a> </div>
  </body>
</html>
