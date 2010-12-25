<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Register</title>
<style type="text/css">
<!--
#table1{
padding:10px;
text-align:right;
font-family:'宋体';
font-size:12px;
color:#666666;
}
.td1{
width:200px;
text-align:right;
font-family:'宋体';
font-size:14px;
color:#000000;
}
.td2{
width:220px;
}
.td2 input{
width:220px;
}
.td3{
padding:4px;
text-align:left;
font-family:'微软雅黑','宋体';
font-size:12px;
color:#1e77d3;
line-height:14px;
background-color:#f3f3f3;
}
-->
</style>
<script type="text/javascript">
function check()
	{
		//alert("adsfa");
		if(form.username.value.length<4)
		{
			alert("The username's length must be lager than 4");
			return false;
		}
		if(form.password.value.length<6)
		{
			alert("The password's length must be lager than 6");
			return false;
		}
		if(form.password.value!=form.password1.value)
		{
			alert("The twice password must be consistent!");
			return false;
		}
		if(form.realname.value.length<1)
		{
			alert("Please input your realname!");
			return false;
		}
		if(form.email.value.length<1)
		{
			alert("Please input your email!");
			return false;
		}
		return true;
	}
</script>
</head>
<body style="margin:30px">
<?php
if($_POST["action"]=="login")
{
	include_once "conn.php";
	$preurl = $_GET["preurl"];
	$username = trim($_POST["username"]);
	$password = md5(trim($_POST["password"]));
	$realname  = $_POST["realname "];
	$email = $_POST["email"];
	$sex = $_POST["sex"];
	$qq = $_POST["qq"];
	$phone = $_POST["phone"];
	$address = $_POST["address"];
	
	if(strlen($username)<4||strlen($password)<6)
	{
		die("<script type='text/javascript'>alert('Sorry ,You have not registed!');history.back(-1);</script>");
	}
	
	if(getresultNumrows(getresult("select * from I_user where username='$username'"))>0)
	{
		die("<script type='text/javascript'>alert('Sorry ,The username have existed!');history.back(-1);</script>");
	}
	
	$query = "insert into I_user(username,password,realname,email,sex,qq,tel,address) values('$username','$password','$realname','$email',$sex,'$qq','$phone','$address')";
	//echo $query;
	if(!getresult($query))
		die("<script type='text/javascript'>alert('Sorry ,You have not registed!');history.back(-1);</script>");
	else
		die("<script type='text/javascript'>alert('Congratulations,You have registe successfully!');window.location='$preurl'</script>");
}
?>
<div align="center">
  <div style="font-family:'微软雅黑','宋体'; font-size:24px; font-weight:bold; text-align:left; width:760px">用户注册</div>
  <div style="width:760px; border:solid #e1e1e1 5px;">
  <form name="form" method="post" action="" onsubmit="return check();">
  <input type="hidden" name="action" value="login" />
        <table width="100%" border="0" cellspacing="8" cellpadding="0">
          <tr>
            <td colspan="3" id="table1">请注意：带有<span style="color:#FF0000"> * </span>的项目必须填写</td>
          </tr>
          <tr>
            <td colspan="3">
           	  <div style="float:left; background:url(images/register_line.gif) repeat-x; width:2%;"></div>
              <div style="float:left; font-family:'宋体'; font-size:14px; font-weight:bold; text-align:center; width:20%;">请填写您的基本信息</div>
              <div style="float:left; background:url(images/register_line.gif) repeat-x; width:78%;"></div>
            </td>
          </tr>
          <tr>
            <td class="td1"><span style="color:#FF0000">* </span>用户名：</td>
            <td class="td2"><input type="text" name="username" id="username" /></td>
            <td class="td3">由字母、数字、下划线、点、减号组成。4～18字符</td>
          </tr>
          <tr>
            <td class="td1"><span style="color:#FF0000">* </span>登录密码：</td>
            <td class="td2"><input type="password" name="password" id="password" /></td>
            <td class="td3">密码长度6～16位，字母区分大小写</td>
          </tr>
          <tr>
            <td class="td1"><span style="color:#FF0000">* </span>重复登录密码：</td>
            <td class="td2"><input type="password" name="password1" id="password1" /></td>
            <td class="td3">请重新输入登录密码，请勿粘贴复制</td>
          </tr>
          <tr>
            <td class="td1"><span style="color:#FF0000">* </span>真实姓名：</td>
            <td class="td2"><input type="text" name="realname" id="realname" /></td>
            <td class="td3">请填写您的真实姓名</td>
          </tr>
          <tr>
            <td class="td1"><span style="color:#FF0000">* </span>E-mail：</td>
            <td class="td2"><input type="text" name="email" id="email" /></td>
            <td class="td3">请填写您真实的电子邮箱，以便联系</td>
          </tr>
            <td colspan="3" style="padding-top:15px;">
       	      <div style="float:left; background:url(images/register_line.gif) repeat-x; width:2%;"></div>
              <div style="float:left; font-family:'宋体'; font-size:14px; font-weight:bold; text-align:center; width:20%;">请填写您的详细信息</div>
              <div style="float:left; background:url(images/register_line.gif) repeat-x; width:78%;"></div>
            </td>
          <tr>
            <td class="td1"><span style="color:#FF0000">* </span>性别：</td>
            <td valign="middle" align="left" style="font-family:'宋体'; font-size:12px;">
              <input name="sex" type="radio" value="0" checked />男&nbsp;<input name="sex" type="radio" value="1" />女            </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td class="td1">QQ：</td>
            <td class="td2"><input type="text" name="qq" id="qq" /></td>
            <td></td>
          </tr>
          <tr>
            <td class="td1">电话：</td>
            <td class="td2"><input type="text" name="phone" id="phone" /></td>
            <td></td>
          </tr>
          <tr>
            <td class="td1">地址：</td>
            <td class="td2"><input type="text" name="address" id="address" /></td>
            <td></td>
          </tr>
            <td colspan="3" style="padding-top:15px;">
       	      <div style="float:left; background:url(images/register_line.gif) repeat-x; width:100%; height:7px; overflow:hidden;"></div>
              <div style="float:left; background:#f8f8f8; width:100%; overflow:hidden; text-align:center; padding-top:10px; padding-bottom:20px;">
                <input name="ok" type="submit" value="提交" style="width:80px"/>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <input name="cancle" type="reset" value="清空" style="width:80px"/>
              </div>
            </td>
        </table>
    </form>
    </div>
</div>
</body>
</html>
