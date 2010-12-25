<?Php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员管理</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				liststyle_mousechange();
			}
		);
</script>
</head>
<body>
<?php
		include "../conn.php";
		include_once '../library/basefunction.php';
		include_once "../lang/envinit.php";
		include "../library/admin.user.php";
		$userid = $_GET["userid"];
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		$iflock = $_GET["iflock"];
		$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
		if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
			die(gettext_r("noRight"));
?>
<?php
	switch($action)
	{
		case "details":
			$result = getresult("select * from I_user where id = $userid");
			$username = getresultData($result,0,"username");
			$realname = getresultData($result,0,"realname");
			$email = getresultData($result,0,"email");
			$qq = getresultData($result,0,"qq");
			$sex = getresultData($result,0,"sex")==0?gettext_r("male"):gettext_r("female");
			$tel = getresultData($result,0,"tel");
			$address = getresultData($result,0,"address");
			$logintimes = getresultData($result,0,"logintimes");
			echo "<table class='poweredit' width='300' border='0' cellspacing='1' cellpadding='0'>";
			echo("<tr>");
			echo("<td>".gettext_r("userName")."(".gettext_r("login").gettext_r("times")."):</td>");
			echo "<td>$username($logintimes)</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td>".gettext_r("name").":</td>");
			echo "<td>$realname</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td>email:</td>");
			echo "<td>$email</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td>qq:</td>");
			echo "<td>$qq</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td>".gettext_r("sex").":</td>");
			echo "<td>$sex</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td>".gettext_r("phoneNumber").":</td>");
			echo "<td>$tel</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td>".gettext_r("address").":</td>");
			echo "<td>$address</td>";
			echo("</tr>");
			echo("<tr class=\"segmentline\"><td colspan=\"2\"/></tr>");
			echo("<tr>");
			echo("<td cosplan=\"2\"><input type='button' onclick='history.back(-1)' value='".gettext_r("back")."' /></td>");
			echo("</tr>");
			echo "</table>";
			break;
		case "delete":
			if(getresult("delete from I_user where id=".$userid))
				die("<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("success")."');window.location=\"$preurl\";</script>");
			else
				die("<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("fail")."');window.location=\"$preurl\";</script>");
			break;
		case "lock":
			if(getresult("update I_user set iflock =".$iflock." where id=".$userid))
				die("<script type=\"text/javascript\">alert('".gettext_r("do").gettext_r("success")."');window.location=\"$preurl\";</script>");
			else
				die("<script type=\"text/javascript\">alert('".gettext_r("do").gettext_r("lock")."');window.location=\"$preurl\";</script>");
			break;
		default:			
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center'>".gettext_r("userName")."</td>\n";
			echo "<td align='center' width='80'>".gettext_r("login").gettext_r("times")."</td>\n";
			echo "<td align='center' width='80'>".gettext_r("ifLock")."</td>\n";
			echo "<td align='center' width='160'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			showuserlist($currentpage);
			echo "</table>\n";
			echo "<div style='height:10px;'></div>";
			echo "<div id='showpage'>";
			showpage($currentpage);
			echo "</div>";
	}
?>
</body>
</html>