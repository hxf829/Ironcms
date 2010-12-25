<?Php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>模板管理</title>
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
		include_once "../conn.php";
		include_once '../library/basefunction.php';
		include_once "../lang/envinit.php";
		include_once "../library/admin.mylabel.php";
		$type = $_GET["type"];//模板类型1为栏目模板，2为文章模板
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		$id = $_GET["id"];
		if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
			die(gettext_r("noRight"));
		$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
?>
<?php
	switch($action)
	{
		case "delete":
		    if(!getresult("delete from I_mylabel where id=".$_GET["id"]))
				die( "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("file")."');window.location=\"$preurl\";</script>");
			else
				die( "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("success")."');window.location=\"$preurl\";</script>");
			break;
		case "add"   :
		    if($_POST["submit"]==gettext_r("submit"))
		    {
				$labelname = "【#MY_".trim($_POST["labelname"])."】";
		        $result = getresult("select * from I_mylabel where labelname='$labelname'");
				if(getresultNumrows($result)<1)
				{
					$labelcontent = $_POST["labelcontent"];
					if(getresult("insert into I_mylabel(labelname,labelcontent) values('$labelname','$labelcontent')"))
						die( "<script type=\"text/javascript\">alert('".gettext_r("add").gettext_r("file")."');window.location='admin_mylabel.php'</script>");	
				}
				else
				{
					die( "<script type=\"text/javascript\">alert('标签已经存在！\\n添加失败');</script>");
				}
		    }
?>
<form action="" method="post">
<table width="100%">
  <tr>
	<td class='label' width="150px"><?php echo gettext_r("selfDefineTip"); ?>：</td>
    <td>【#MY_<input type="text" name="labelname" />】</td>
  </tr>
  <tr>
	<td class='label'><?php echo gettext_r("selfDefineTip").gettext_r("contents"); ?>：</td>
    <td><textarea name="labelcontent" style="width:95%; height:500px;"></textarea></td>
  </tr>
  <tr>
  	<td></td>
	<td><input type="submit" name="submit" value="<?php echo gettext_r("submit"); ?>" /><input type="reset" value="<?php echo gettext_r("cancle"); ?>" /></td>
  </tr>
</table>
</form>
<?php
			break;
		case "modify":
		    $label = getresult("select * from I_mylabel where id =$id");
	        if($_POST["submit"]==gettext_r("submit"))
		    {
		     	//修改自定义标签
				$id = $_GET["id"];
				$labelcontent = $_POST["labelcontent"];
				//echo "update I_mylabel set labelcontent='$labelcontent' where id=$id";
				if(getresult("update I_mylabel set labelcontent='".mysql_escape_string($labelcontent)."' where id=$id"))
				{
					die( "<script type=\"text/javascript\">alert('".gettext_r("update").gettext_r("success")."');window.location='admin_mylabel.php'</script>");	
				}
				else
				{
					//echo "update I_mylabel set labelcontent='$labelcontent' where id=$id";
					die( "<script type=\"text/javascript\">alert('".gettext_r("update").gettext_r("fail")."');history.back(-1);</script>");
				}
		    }
?>
<form action="" method="post">
<table width="100%">
  <tr>
	<td class='label' width="150px"><?php echo gettext_r("selfDefineTip"); ?>：</td>
    <td><input type="text" name="labelname" disabled="disabled" value="<?php echo getresultData($label,0,"labelname") ?>" /></td>
  </tr>
  <tr>
	<td class='label'><?php echo gettext_r("selfDefineTip").gettext_r("contents"); ?>：</td>
    <td><textarea name="labelcontent" style="width:95%; height:500px;"><?php echo getresultData($label,0,"labelcontent") ?></textarea></td>
  </tr>
  <tr>
  	<td></td>
	<td><input type="submit" name="submit" value="<?php echo gettext_r("submit"); ?>" /><input type="button" onclick="history.back(-1)" value="<?php echo gettext_r("back"); ?>" /></td>
  </tr>
</table>
</form>
<?php
			break; 
		default:
			echo "<div id='navigation'>".gettext_r("quickLink").":　　";
			echo "<a href=\"admin_mylabel.php?action=add\">".gettext_r("add").gettext_r("selfDefineTip")."</a>\n";
			echo "</div>";
			
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center' width='300'>".gettext_r("selfDefineTip").gettext_r("name")."</td>\n";
			echo "<td align='center'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			showmylabel($currentpage);
			echo "</table>\n";
			echo "<div style='height:5px;'></div>";
			echo "<div id='showpage'>";
			showpage($currentpage);
			echo "</div>";
	}
?>
</body>
</html>
