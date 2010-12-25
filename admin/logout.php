<?php
	session_start();
	session_destroy();
	setcookie("adminid");				
	setcookie("adminrole");
	setcookie("functioncode");
	setcookie("adminname");
	die("<script type=\"text/javascript\">window.location='login.php';</script>")
?>