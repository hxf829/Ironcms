<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>评论管理</title>
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
		include_once "../library/basefunction.php";
		include_once "../lang/envinit.php";
		include "../library/admin.comment.php";
		$functionarray = translatefunctioncode($_SESSION["functioncode"]);
		$columnid = $_GET["columnid"];
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
?>
<?php
	switch($action)
	{
		case "delete":
			if(!getresult("delete from I_comment where id=".$_GET["commentid"]))
				echo "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("fail")."');window.location=\"$preurl\";</script>";
			else
				echo "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("success")."');window.location=\"$preurl\";</script>";
			break;
		case "pass":
			getresult("update I_comment set ifpass=".$_GET["ifpass"]." where id=".$_GET["commentid"]);
			break;
		default:
			echo "<div id='navigation'>".gettext_r("quickLink")."：";
			showchildcolumncomment($columnid);
			//echo "<a href=\"admin_comment.php?columnid=".$columnid."\">添加文章</a>\n";
			echo "";
			echo "</div>";
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='40'>".gettext_r("checkIn")."</td>\n";
			echo "<td align='center' width='50'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center' width='140'>".gettext_r("article")."</td>\n";
			echo "<td align='center' width='600'>".gettext_r("contents")."</td>\n";
			echo "<td align='center' width='100'>".gettext_r("author")."</td>\n";
			echo "<td align='center' width='100'>".gettext_r("ifPass")."</td>\n";
			echo "<td align='center' width='100'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			showcomment($columnid, $currentpage);
			echo "</table>\n";
			echo "<div style='height:5px;'></div>";
			echo "<input type='checkbox' id='checkall' onclick='checkall()' value='全选' /><span>".gettext_r("checkAll")."　　</span> ";
			echo "<input type='button' onclick=\"deleteall('admin_comment.php')\" value='".gettext_r("deleteAll")."' />";
			echo "<input type='button' onclick='passcomment(1)' value='".gettext_r("pass")."' />";
			echo "<input type='button' onclick='passcomment(0)' value='".gettext_r("canclePass")."' />";
			
			echo "<div id='showpage'>";
			showcommentpage($columnid, $currentpage);
			echo "</div>";
	}
?>
</body>
</html>
