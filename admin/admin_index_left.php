<?php
session_start();
?>
<?php
	include_once("../conn.php");
	include_once('../library/basefunction.php');
	include_once "../lang/envinit.php";
	if(getlogininfo("adminrole")=="notdefined")
		echo "<script type='text/javascript'>parent.location='login.php';</script>"
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>left</title>
    <link href="css/menu.css" rel="stylesheet" type="text/css" />
    <link href="css/left.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/adminmainFunction.js"></script>
    <script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				initMenu();
			}
		);
    </script>
</head>

<body>
    <div id="MN_pic"></div>
    <div id="MN_line"></div>
    <div id="MN_href"><a href="admin_index_main.html" target="main"><?php echo gettext_r("adminIndex");?></a>&nbsp;|&nbsp;<a href="../" target="_blank"><?php echo gettext_r("siteIndex");?></a></div>
    <div id="MN_line"></div>
    <div id="MN_menu">
	  <?php 
	    include "left.php";
	  ?>
	</div>
</body>
</html>
