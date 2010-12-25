<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>修改密码</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>

</head>
<body style="padding:20px;" bgcolor="#f3f9ff">
<?php 
	if($_POST["submit"]=="提交")
	{
		include '../conn.php';
		include '../library/basefunction.php';
		$adminid = getlogininfo("adminid");
		$result = getresult("select * from I_admin where id = $adminid");
		if(md5($_POST["oldpassword"])!=getresultData($result,0,"password"))
		{
			die( "<script type='text/javascript'>alert('旧密码错误');history.back(-1);</script>");
		}
		if($_POST["newpwd"]!=$_POST["newpwd1"])
		{
			die( "<script type='text/javascript'>alert('两次密码输入不一致');history.back(-1);</script>");
		}
		if(getresult("update I_admin set password='".md5($_POST["newpwd"])."' where id=$adminid"))
		{
			die( "<script type='text/javascript'>alert('密码修改成功\\n请重新登录');parent.location='logout.php';</script>");
		}
	}
?>
<div>
<form action="" method="post" onSubmit="return chpasswordcheck();">
  <table cellspacing="0" cellpadding="3" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
    <tr>
      <td class="label" width="100px">密码：</td>
      <td><input type="password" name="oldpassword"></td>
      <td valign="center" style="font-size:12px; color:#0000CC; padding-left:10px;">* 请输入您现在正在使用的密码　</td>
    </tr>
    <tr>
      <td class="label">新密码：</td>
      <td><input type="password" name="newpwd"></td>
      <td valign="center" style="font-size:12px; color:#0000CC; padding-left:10px; padding-right:10px;">* 请输入您要修改的新密码，区分大小写　</td>
    </tr>
    <tr>
      <td class="label">重复新密码：</td>
      <td><input type="password" name="newpwd1"></td>
      <td valign="center" style="font-size:12px; color:#0000CC; padding-left:10px;">* 请重复输入新密码，请勿粘贴复制　</td>
    </tr>
    <tr>
      <td style="border-width:0px;"></td>
      <td style="border-width:0px;"><input name="submit" type="submit" value="提交" style="width:60px"></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>