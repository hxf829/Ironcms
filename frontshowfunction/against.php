<?php
	include_once "../conn.php";
	$commentid = $_GET["commentid"];
	getresult("update I_comment set against=against+1 where id=$commentid");
?>