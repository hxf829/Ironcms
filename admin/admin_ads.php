<?Php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				liststyle_mousechange();
				lockeachother();
			}
		);
</script>
</head>
<body>
<?php
	  include "../conn.php";
	  include_once "../library/basefunction.php";
	  include_once "../lang/envinit.php";
	  include "../library/admin.ads.php";
	  $adminid = $_GET["adminid"];
	  $action = $_GET["action"];
	  $preurl = $_GET["url"];
	  //检查权限超管权限，不是超管不能进行此项管理
	  if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
		  die(gettext_r("noRight"));
?>
</body>
</html>