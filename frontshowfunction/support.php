<?php
	include_once "../conn.php";
	$commentid = $_GET["commentid"];
	getresult("update I_comment set support=support+1 where id=$commentid");
?>