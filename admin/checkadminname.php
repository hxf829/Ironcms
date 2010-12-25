<?php
	include "../conn.php";
	$adminname = $_GET["adminname"];
	$tempresult = getresult("select * from I_admin where adminname='$adminname'");
	if(getresultNumrows($tempresult)>=1)
		{
			echo "exist";
		}
	else 
		{
			echo "not";
		}
?>