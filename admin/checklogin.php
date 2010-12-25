<?php
	include "../library/basefunction.php";
	if(getlogininfo("adminname")=="notdefined")
		echo "notlogin";
	else
		echo "logined";
?>