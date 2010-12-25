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
		include "../library/admin.admin.php";
		$adminid = $_GET["adminid"];
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		//检查权限超管权限，不是超管不能进行此项管理
		if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
			die(gettext_r("noRight"));
?>
<?php
	switch($action)
	{
		case "delete":
			//至少保留一个超管
			try
			{
				getresult("begin");
				getresult("delete from I_admin where id=".$adminid);
				//echo getresultRow(getresult("select * from I_admin where adminrole=0"));
				if(getresultRow(getresult("select * from I_admin where adminrole=0"))<1)
				{
					getresult("rollback");
					throw new Exception(gettext_r("superManagerLeastOne"));
				}
				getresult("commit");
				getresult("end");
				die("<script type='text/javascript'>alert(\"".gettext_r("delete").gettext_r("success")."\");window.location='admin_admin.php'</script>");
			}
			catch(Exception $e)
			{
				echo $e->getMessage();
				die("<script type='text/javascript'>alert(\"".gettext_r("delete").gettext_r("fail")."\");history.back(-1)</script>");
			}
			break;
		case "add"   :
			if($_POST["submmit"]==gettext_r("submit"))
			{
				$adminname = trim($_POST["adminname"]);
				$tempresult = getresult("select * from I_admin where adminname='$adminname'");
				if(getresultNumrows($tempresult)>=1)
				{
					echo "<script type=\"text/javascript\">alert('".gettext_r("adminNameAlreadyExist")."');history.back(-1);</script>";
					die();
				}
				$pwd = md5(trim($_POST["pwd"]));
				if($_POST["adminrole"]!=1)
				{
					//是超级管理员
					$query = "insert into I_admin(adminname,password,adminrole) values('$adminname','$pwd',0)";
					getresult($query);
					echo "<script type=\"text/javascript\">alert('".gettext_r("add").gettext_r("success")."');window.location='admin_admin.php';</script>";
					die();
				}
				$result = getresult("select * from I_column where parentid=0");
				$functioncode = "";
				
				$index=0;
				while($row = getresultArray($result))
				{
					if($index==0)
					{
						if($_POST[$row["id"]]!=0)
						{
							$functioncode .= $row["id"]."|".$_POST[$row["id"]];
							$index++;
						}
					}
					else
					{
						if($_POST[$row["id"]]!=0)
							$functioncode .= ",".$row["id"]."|".$_POST[$row["id"]];
					}
				}
				if($_POST["voteadmin"]==1)
				{
					if($functioncode=="")
						$functioncode = "vote|1";
					else
						$functioncode .= ",vote|1";
				}
				$query = "insert into I_admin(adminname,password,adminrole,functioncode) values('$adminname','$pwd',1,'$functioncode')";
				getresult($query);
				echo "<script type=\"text/javascript\">alert('".gettext_r("add").gettext_r("success")."');window.location='admin_admin.php';</script>";
				die();
				//echo $functioncode;
			}
?>
<form id="form1" name="form1" method="post" action="" onsubmit="return admin_form_check()">
<table class="admininfo" cellspacing="0" cellpadding="3" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
  <tr>
    <td class="label" width="80" align="right"><?php echo gettext_r("manager").gettext_r("name"); ?>：</td>
    <td><input id="adminname" type="text" value="" name="adminname" />　<a style="text-decoration:none; color:#009966; font-size:13px;" onclick="checkadminname($('#adminname').val(),this)" href="#"><?php echo gettext_r("check").gettext_r("manager").gettext_r("name"); ?></a>　</td>
  </tr>
    <tr>
    <td class="label" align="right"><?php echo gettext_r("password"); ?>：</td>
    <td><input type="password" value="" name="pwd" /></td>
  </tr>
   <tr>
    <td class="label" align="right"><?php echo gettext_r("repeat").gettext_r("name"); ?>：</td>
    <td><input type="password" value="" name="pwd1" /></td>
  </tr>
 </table>
 <input type="radio" name="adminrole" checked="checked" onclick="$('#powerdetail').show()" value="1" /><?php echo gettext_r("common").gettext_r("manager"); ?> <input type="radio" name="adminrole" onclick="$('#powerdetail').hide()" value="0" /><?php echo gettext_r("super").gettext_r("manager"); ?><br />
 <div id="powerdetail">
 <div style="padding-top:10px;"><strong><?php echo gettext_r("power").gettext_r("config"); ?>：</strong></div>
<table class="poweredit" width="500" border="0" cellspacing="1" cellpadding="0">
<?php
showpowerlist();
?>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>
</div>
　　　　　　　　<input type="submit" name="submmit" value="<?php echo gettext_r("submit");?>" />　　<input type="reset" value="<?php echo gettext_r("cancle");?>" />
</form>
<?php
			break;
		case "modify":
			$result = getresult("select * from I_admin where id=$adminid");
			//echo $_SESSION["adminname"];
			$adminname = getresultData($result,0,"adminname");
			//echo $_SESSION["adminname"];
			$pwd = getresultData($result,0,"password");
			$adminrole = getresultData($result,0,"adminrole");
			if($_POST["submmit"]==gettext_r("submit"))
			{
				$adminname = trim($_POST["adminname"]);
				$pwd = md5(trim($_POST["pwd"]));
				if($_POST["adminrole"]!=1)
				{
					//是超级管理员
					$query = "update I_admin set adminname='$adminname',password='$pwd',adminrole=0 where id=$adminid";
					getresult($query);
					echo "<script type=\"text/javascript\">alert('".gettext_r("update").gettext_r("success")."');window.location='admin_admin.php';</script>";
					die();
				}
				$result = getresult("select * from I_column where parentid=0");
				$functioncode = "";
				
				$index=0;
				while($row = getresultArray($result))
				{
					if($index==0)
					{
						if($_POST[$row["id"]]!=0)
						{
							$functioncode .= $row["id"]."|".$_POST[$row["id"]];
							$index++;
						}
					}
					else
					{
						if($_POST[$row["id"]]!=0)
							$functioncode .= ",".$row["id"]."|".$_POST[$row["id"]];
					}
				}
				if($_POST["voteadmin"]==1)
				{
					if($functioncode=="")
						$functioncode = "vote|1";
					else
						$functioncode .= ",vote|1";
				}
				$query = "update I_admin set adminname='$adminname',password='$pwd',adminrole=1,functioncode='$functioncode' where id=$adminid";
				getresult($query);
				echo "<script type=\"text/javascript\">alert('".gettext_r("update").gettext_r("success")."');window.location='admin_admin.php';</script>";
				die();
				//echo $functioncode;
			}
?>
<form id="form1" name="form1" method="post" action="" onsubmit="return admin_form_check()">
<table class="admininfo" cellspacing="0" cellpadding="3" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
  <tr>
    <td class="label" width="80" align="right"><?php echo gettext_r("manager").gettext_r("name"); ?>：</td>
    <td><input id="adminname" type="text" value="<?php echo $adminname; ?>" name="adminname" />　<a style="text-decoration:none; color:#009966; font-size:13px;" onclick="checkadminname($('#adminname').val(),this)" href="#"><?php echo gettext_r("check").gettext_r("manager").gettext_r("name"); ?></a>　</td>
  </tr>
    <tr>
    <td class="label" align="right"><?php echo gettext_r("password"); ?>：</td>
    <td><input type="password" value="<?php echo $adminname; ?>" name="pwd" /></td>
  </tr>
   <tr>
    <td class="label" align="right"><?php echo gettext_r("repeat").gettext_r("name"); ?>：</td>
    <td><input type="password" value="<?php echo $adminname; ?>" name="pwd1" /></td>
  </tr>
 </table>
 <input type="radio" name="adminrole" checked="checked" onclick="$('#powerdetail').show()" value="1" /><?php echo gettext_r("common").gettext_r("manager"); ?> <input type="radio" name="adminrole" onclick="$('#powerdetail').hide()" value="0" /><?php echo gettext_r("super").gettext_r("manager"); ?><br />
 <div id="powerdetail">
 <div style="padding-top:10px;"><strong><?php echo gettext_r("power").gettext_r("config"); ?>：</strong></div>
<table class="poweredit" width="500" border="0" cellspacing="1" cellpadding="0">
<?php
showpowerlist($adminid);
?>
</table>
</div>
<?php
if($adminrole==0)
{
	echo "<script type=\"text/javascript\">$(\"input[value=0]\").attr('checked','true');$('#powerdetail').hide();</script>";
}
?>
　　　　　　　　<input type="submit" name="submmit" value="<?php echo gettext_r("submit");?>" />　　<input type="reset" value="<?php echo gettext_r("cancle");?>" />
</form>
<?php
			break; 
		default:
			echo "<div id='navigation'>".gettext_r("quickLink")."：";
			echo "<a href=\"admin_admin.php?action=add\">".gettext_r("add").gettext_r("manager")."</a>\n";
			echo "</div>";
			
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='40'>".gettext_r("checkIn")."</td>\n";
			echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center' width='150'>".gettext_r("manager").gettext_r("name")."</td>\n";
			echo "<td align='center'>".gettext_r("power")."</td>\n";
			echo "<td align='center' width='120'>".gettext_r("last").gettext_r("login")." IP</td>\n";
			echo "<td align='center' width='150'>".gettext_r("last").gettext_r("login").gettext_r("time")."</td>\n";
			echo "<td align='center' width='80'>".gettext_r("login").gettext_r("times")."</td>\n";
			echo "<td align='center' width='100'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			showadminlist();
			echo "</table>\n";
			echo "<div style='height:5px;'></div>";
			echo "<input type='checkbox' id='checkall' onclick='checkall()' value='全选' /><span>".gettext_r("checkAll")."　　</span> ";
			echo "<input type='button' onclick=\"deleteall('admin_admin.php')\" value='".gettext_r("deleteAll")."' />";
	}
?>
</body>
</html>
