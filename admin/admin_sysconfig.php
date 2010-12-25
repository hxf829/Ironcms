<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<title>网站信息配置</title>
</head>
<body>
<?php
include_once "../conn.php";
include_once "../library/basefunction.php";
include_once "../lang/envinit.php";
//检查权限
if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
	die(gettext_r("noRight"));
//信息处理部分
if($_POST["submit"]==gettext_r("submit"))
{
	//修改网站配置
	if(getresult("update I_siteconfig set domain='".$_POST["sitedomain"]."',sitename='".$_POST["sitename"]."',logo='".$_POST["logo"]."', adminemail='".$_POST["adminemail"]."', keywords='".str_replace("'","''",$_POST["keywords"])."', copyright='".str_replace("'","''",$_POST["copyright"])."',indextemplate=".$_POST["indextemplate"].",adminlang='".$_POST["adminlang"]."',frontlang='".$_POST["frontlang"]."'"))
	{
		echo "<script type='text/javascript'>alert('".gettext_r("update").gettext_r("success")."');window.location=window.location;</script>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('".gettext_r("update").gettext_r("fail")."');</script>";
	}
}
$result = getresult("select * from I_siteconfig");
$row = getresultArray($result);
$sitedomain = $row["domain"];
$sitename = $row["sitename"];
//$sitelanguage = $row["sitelanguage"];
$logo = $row["logo"];
$adminemail = $row["adminemail"];
$keywords = $row["keywords"];
$copyright = $row["copyright"];
$indextemplate = $row["indextemplate"];
$adminlang = $row["adminlang"];
$frontlang = $row["frontlang"];
?>
<form id="form1" name="form1" method="post" action="" onsubmit="return siteConfigCheck()">
<table width="100%" cellspacing="0" cellpadding="3" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
   <tr>
    <td class='label'><?php echo gettext_r("siteDomain"); ?>：</td>
    <td class='attributeinput'><input value="<?php if($sitedomain==NULL||$sitedomain=="")echo "http://".$_SERVER['HTTP_HOST']."/"; else echo $sitedomain; ?>" type="text" name="sitedomain" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("siteName"); ?>：</td>
    <td class='attributeinput'><input value="<?php echo $sitename; ?>" type="text" name="sitename" /></td>
  </tr>
<!--  <tr>
    <td class='label'>网站语言：</td>
    <td class='attributeinput'><input value="" type="text" name="sitelanguage" /></td>
  </tr>-->
  <tr>
    <td class='label'><?php echo gettext_r("adminLang"); ?>：</td>
    <td class='attributeinput'><input value="<?php echo $adminlang; ?>" type="text" name="adminlang" /> *填写zh-cn代表中文；填写en代表英文</td>
  </tr>
  
  <tr>
    <td class='label'><?php echo gettext_r("frontLang"); ?>：</td>
    <td class='attributeinput'><input value="<?php echo $frontlang; ?>" type="text" name="frontlang" /> *填写zh-cn代表中文；填写en代表英文</td>
  </tr>
  
  <tr>
    <td class='label'><?php echo gettext_r("logo"); ?>：</td>
    <td class='attributeinput'><input  value="<?php echo $logo; ?>" type="text" name="logo" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("adminEmail"); ?>：</td>
    <td class='attributeinput'><input value="<?php echo $adminemail; ?>" type="text" name="adminemail" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("keywords"); ?>：</td>
    <td class='attributeinput'><input value="<?php echo $keywords; ?>" type="text" name="keywords" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("indextempalte"); ?>：</td>
    <td class='attributeinput'>
    <?php
		echo "<select name='indextemplate'>";
    	$indextemplateresult = getresult ( "select id,templatename from I_template where templatetype=3" );
		while ( list ( $id, $templatename ) = getresultRow ( $indextemplateresult ) ) {
			if ($id == $indextemplate)
				echo "<option selected=\"selected\" value='$id'>$templatename</option>\n";
			else
				echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select>\n";
	?>
    </td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("copyRight"); ?>：</td>
    <td class='attributeinput'><textarea name="copyright"><?php echo $copyright; ?></textarea></td>
  </tr>
  <tr>
    <td style="border-width:0px;"></td>
    <td height="60px;" style="border-width:0px;"><input type="submit" value="<?php echo gettext_r("submit"); ?>" name="submit"/>&nbsp;&nbsp;<input type="button" onclick="history.back(-1)" value="<?php echo gettext_r("back"); ?>" /></td>
  </tr>
</table>
</form>
</body>
</html>
