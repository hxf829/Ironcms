<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>article</title>
<link type="text/css" rel="stylesheet" href="css/article.css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/front.js"></script>
</head>
<body>
<?php
	include "conn.php";
	include 'frontshowfunction/frontbasefunction.php';
	$articleid = $_GET["id"];
?>
<div id="article">
<?php
	getresult("update I_article set hits=hits+1 where id = $articleid");
	showarticle($articleid);
?>
</div>
</body>
</html>