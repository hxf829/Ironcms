<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>articlelist</title>
<link type="text/css" rel="stylesheet" href="css/ui.tabs.css" />
<link type="text/css" rel="stylesheet" href="css/article.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.tabs.js"></script>
<script type="text/javascript" src="js/front.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#tabs").tabs();
  });
  </script>
</head>
<body style="background-color:transparent">
<?php
	include "conn.php";
	include 'frontshowfunction/frontbasefunction.php';
	$columnid = $_GET["columnid"];
	$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
?>

<div id="tabs">
<?php
    if($_GET["firstletter"]!=NULL&&$_GET["firstletter"]!="")
    {
        echo "All article whose first letter is \"<font color=red>".$_GET["firstletter"]."</font>\" are listed.";
        echo "<div style='height:7px;'></div>";
        showletersearch($_GET["firstletter"],$currentpage);
    }
    else
	    showchildcolumnlist($columnid);
?>
</div>
</body>
</html>