<?php
ob_start ();
session_start ();
include_once "../conn.php";
include_once "../library/basefunction.php";
include_once "../lang/envinit.php";
include_once "../library/admin.log.php";
?>

<?php
$action = $_POST ["action"];
if ($action == "login") {
	//echo $_POST["confirmstr"]."|".$_SESSION['randcode'];
	if ($_SESSION ['randcode'] == NULL) {
		die ( "<script type=\"text/javascript\">alert('等待时间过长');window.location=\"login.php\"</script>" );
	}
	if ($_POST ["confirmstr"] != $_SESSION ['randcode']) {
		die ( "<script type=\"text/javascript\">alert('验证码不正确');window.location=\"login.php\"</script>" );
	}
	
	$adminname = $_POST ["adminname"];
	$password = md5 ( $_POST ["password"] );
	try {
		$query = "select * from I_admin where adminname = '" . $adminname . "' and password = '" . $password . "'";
		$result = getresult ( $query );
		if (! getresultNumrows ( $result )) {
			throw new Exception ( gettext_r("login").gettext_r("fail") );
		} else {
			$id = getresultData ( $result, 0, "id" );
			
			$_SESSION ["adminid"] = getresultData ( $result, 0, "id" );
			$_SESSION ["adminrole"] = getresultData ( $result, 0, "adminrole" );
			$_SESSION ["functioncode"] = getresultData ( $result, 0, "functioncode" );
			$_SESSION ["adminname"] = $adminname;
			setcookie ( "adminid", getresultData ( $result, 0, "id" ) );
			setcookie ( "adminrole", getresultData ( $result, 0, "adminrole" ) );
			setcookie ( "functioncode", getresultData ( $result, 0, "functioncode" ) );
			setcookie ( "adminname", $adminname );
			
			getresult ( "update I_admin set logintimes=logintimes+1,lastip='" . $_SERVER ["REMOTE_ADDR"] . "',lasttime=CURRENT_TIMESTAMP where id=$id" );
			//写日志
			$newLog = new Log();
			$newLog->adminName = $adminname;
			$newLog->logType = 0;
			$newLog->operateContent = gettext_r("login").gettext_r("success");
			$newLog->ip = $_SERVER ["REMOTE_ADDR"]."";
			if(!$newLog->Add())
				echo ("<script type=\"text/javascript\">alert('日志存储错误')</script>");
			echo ("<script type=\"text/javascript\">window.location=\"admin_index.php\"</script>");
		}
	} catch ( Exception $e ) {
		$newLog = new Log();
		$newLog->adminName = $adminname;
		$newLog->logType = 0;
		$newLog->operateContent = gettext_r("login").gettext_r("fail");
		$newLog->ip = $_SERVER ["REMOTE_ADDR"]."";
		if(!$newLog->Add())
			echo ("<script type=\"text/javascript\">alert('日志存储错误')</script>");
		echo ($e->getMessage ());
		die ( "<script type=\"text/javascript\">window.location=\"login.php\"</script>" );
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo gettext_r("manager").gettext_r("login"); ?></title>
<link href="css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<script type="text/javascript">
$(document).ready(
	function() 
	{ 
		$("#adminname").focus();
	}
);
</script>
<script type="text/javascript">
function focus_style(obj)
{
	$(obj).replaceWith("<input name=\"password\" type=\"password\" id=\"password\"/>"); 
	$("input[type='password']").focus();
}
//login表单验证
function Check()
{
	if($.trim($("#adminname").val())=="" || $.trim($("#adminname").val())=="<?php echo gettext_r("userName") ?>")
		return false;
	if($.trim($("#password").val())=="" || $.trim($("#password").val())=="<?php echo gettext_r("password") ?>")
		return false;
	return true;
}
</script>
</head>

<body>
<form id="form1" name="form1" method="post" action="" onsubmit="return Check();">
<!--第一部分图片&单位开始-->
<div id="main1">
  <table align="center">
    <tr>
      <td id="m1_pic"></td>
      <td id="m1_text" valign="top">
        <div id="m1_text_user"><span><?php $siteconfig = getresult("select * from I_siteconfig limit 0,1");
	echo getresultData($siteconfig, 0, "sitename");?></span></div>
        <div id="m1_text_login"><span><?php echo gettext_r("login"); ?></span></div>
      </td>
    </tr>
  </table>
</div>
<!--第一部分图片&单位结束-->

<!--第二部登录表单开始-->
<div id="main2">
  <table align="center">
    <tr>
      <td id="m2_input1" align="left" valign="top"><input name="adminname" type="text" id="adminname" value="<?php echo gettext_r("userName"); ?>" onfocus="javascript:this.select()"/></td>
    </tr>
    <tr>
      <td id="m2_input2" align="left" valign="top">
      <input name="password" type="text" id="password" value="<?php echo gettext_r("password"); ?>" onfocus="focus_style(this);"/>
      </td>
    </tr>
    <tr>
      <td id="m2_input3" align="left" valign="top">
      <div><input name="confirmstr" type="text" id="confirmstr" value="<?php echo gettext_r("confirmCode"); ?>" maxlength="4" onfocus="javascript:this.select()"/>
      <img title="<?php echo gettext_r("confirmCodeTips"); ?>" id="confirmimage" onclick="changeconfirmimage()" style="cursor: pointer;" src="../library/confirmimage.php"/></div>
      </td>
    </tr>
    <tr>
      <td id="m2_button">
      <input name="action" value="login" style="display: none;" />
        <input id="m2_bt_out" type="submit" name="enter" value="<?php echo gettext_r("login"); ?>" onmouseover="this.id='m2_bt_over'" onmouseout="this.id='m2_bt_out'"/>
        &nbsp;&nbsp;
        <input id="m2_bt_out" type="reset" name="reset" value="<?php echo gettext_r("cancle"); ?>" onmouseover="this.id='m2_bt_over'" onmouseout="this.id='m2_bt_out'"/>
      </td>
    </tr>
  </table>
</div>
<!--第登录表单结束-->
<div id="logo">
  <table align="center">
    <tr>
      <td></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>
