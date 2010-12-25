<?Php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理</title>
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
include "../library/admin.log.php";
$action = $_GET ["action"];
$id = $_GET ["id"];
$preurl = $_GET ["url"];
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
$pagesize = ($_GET["pagesize"]==NULL || $_GET["pagesize"]<=0)?10:$_GET["pagesize"];
$logtype = ($_GET["logtype"]==NULL || $_GET["logtype"]<=0)?0:$_GET["logtype"];
//检查权限
if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
	die(gettext_r("noRight"));

?>
<?php

switch ($action) {
	case "delete" :
		if(!getresult("delete from I_log where id=".$id))
			echo "<script type='text/javascript'>alert('".gettext_r("delete").gettext_r("fail")."');window.location=".$preurl."</script>";
		echo "<script type='text/javascript'>alert('".gettext_r("delete").gettext_r("success")."');window.location=".$preurl."</script>";
		break;
	//列出栏目列表，对其进行操作
	default :
		//begin
		echo "<div id='navigation'>".gettext_r("quickLink")."：";
		echo "<a href=\"admin_log.php?logtype=0\">".gettext_r("login").gettext_r("log")."</a>\n";
		echo "<a href=\"admin_log.php?logtype=1\">".gettext_r("do").gettext_r("log")."</a>\n";
		echo "</div>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
		echo "<tr class='header'>\n";
		echo "<td align='center' width='40'>".gettext_r("checkIn")."</td>\n";
		echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
		echo "<td align='center' width='100'>".gettext_r("manager")."</td>\n";
		echo "<td align='center'>".gettext_r("do").gettext_r("contents")."</td>\n";
		echo "<td align='center' width='100'>IP</td>\n";
		echo "<td align='center' width='150'>".gettext_r("do").gettext_r("time")."</td>\n";
		echo "</tr>\n";
		$allLogs = new Logs();
		$allLogs->getAllLog($currentpage,$pagesize,$logtype);
		$allLogs->showAllLog();
		echo "</table>\n";
		echo "<div style='height:5px;'></div>";
		echo "<input type='checkbox' id='checkall' onclick='checkall()' value='全选' /><span>".gettext_r("checkAll")."　　</span> ";
		echo "<input type='button' onclick=\"deleteall('admin_log.php')\" value='".gettext_r("deleteAll")."' />";
		echo "<div id='showpage'>";
		$allLogs->showLogpage($currentpage,$pagesize,$logtype);
		echo "</div>";
}
?>
</body>
</html>
