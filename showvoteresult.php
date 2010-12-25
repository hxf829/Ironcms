<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>投票结果查询</title>
<style type="text/css">
<!--
body{
background:#94c8bb url(images/vote_bg.jpg) no-repeat;
margin:0px;
}
#vote_title{
font-family:"微软雅黑","宋体";
font-size:14px;
font-weight:bold;
color:#FFFFFF;
padding-left:40px;
padding-top:5px;
}
#vote_a{
font-family:"宋体";
font-size:12px;
color:#FFFFFF;
}
#vote_a a{
color:#FFFFFF;
text-decoration:none;
}
#vote_a a:hover{
color:#FFFFFF;
text-decoration:underline;
}
.vote_main_td1{
font-family:"宋体";
font-size:12px;
color:#000000;
text-align:right;
padding:18px;
border-bottom:#bbbbbb solid 1px;
}
.vote_main_td2{
width:400px;
border-bottom:#bbbbbb solid 1px;
}
.vote_main_td2 div{
float:left;
height:21px;
background:url(images/vote_fg_main.png) repeat-x;
font-family:"微软雅黑","宋体";
font-size:12px;
color:#ffffff;
line-height:20px;
padding-left:5px;
}
.vote_main_td3{
font-family:"宋体";
font-size:14px;
color:#000000;
text-align:left;
border-bottom:#bbbbbb solid 1px;
}
.vote_main_td3 span{
color:#890000;
font-weight:bold;
}
#vote_main_note{
font-family:"宋体";
font-size:12px;
color:#ce0000;
text-align:right;
padding-top:20px;
}
-->
</style>
</head>
<body>
<table width="959px" border="0" cellspacing="0" cellpadding="0" style="margin-top:80px; margin-left:21px">
  <tr>
    <td height="29px" style="background:url(images/vote_fg1.png) no-repeat"></td>
  </tr>
<?php
	$voteid = $_GET["voteid"];
	
	//根据调查类型执行投票
	include "conn.php";
	include_once 'library/basefunction.php';
	include_once 'lang/envinit.php';
	
	$result = getresult("select * from I_vote where id=$voteid");
	
	if($result==NULL||getresultNumrows($result)<1)
		die("<script type='text/javascript'>window.location='error.html'</script>");
		
	//首先判断是否已经投过票（通过ip记录）
	$userip = $_SERVER ["REMOTE_ADDR"];
	$ifhavevoted = getresultNumrows(getresult("select * from I_iprecord where action='vote' and ip='".$userip."'"));
	if ($ifhavevoted > 0)
	{
		echo "<script type='text/javascript'>alert('".gettext_r("youhavevoted")."')</script>";
	}
	else
	{
		$votetype = getresultData($result, 0, "type");
		//接收投票信息
		if($_POST["votetype"]!=NULL&&$_POST["votetype"]!="")
		{
			//区分多选和单选
			if($_POST["votetype"]==0)
			{
				if($_POST["option"]!=NULL&&$_POST["option"]!="")
				{
					getresult("update I_vote set count".$_POST["option"]."=count".$_POST["option"]."+1 where id=$voteid");
				}
			}
			else
			{
				if($_POST["option"]!=NULL&&$_POST["option"]!="")
				{
					$option = $_POST["option"];
					//echo count($option);
					for($i=0; $i<count($option); $i++)
					{
						getresult("update I_vote set count".$option[$i]."=count".$option[$i]."+1 where id=$voteid");
					}
				}
			}
		}
		//添加投票记录
		if(!getresult("insert into I_iprecord(ip,action,actionid,user) values('".$userip."','vote',".$voteid.",'".$_SESSION["username"]."')"))
		{
			//echo "insert into I_iprecord(ip,action,actionid,user) values('".$userip."','vote',".$voteid.",'".$_SESSION["userid"]."')";
		}
	}
	
	$countOfOption = getresultData($result, 0, "attrcount")+1;
	$countOfAll = 0;
	for($i = 1; $i<$countOfOption; $i++)
	{
		$countOfAll += getresultData($result, 0, "count".$i);
	}
	
	echo "<tr><td height='46px' style='background:url(images/vote_fg2.png) repeat-y' valign='top' id='vote_title'>".gettext_r("title")."：".getresultData($result, 0, "title")."</td></tr>";
	echo "<tr>";
    echo "<td height='19px' style='background:url(images/vote_fg3.png) no-repeat'></td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td style='background:url(images/vote_fg4.png) repeat-y'>";
    echo "<table width='820px' border='0' cellspacing='0' cellpadding='0' style='margin-left:70px'>";
	for($i = 1; $i<$countOfOption; $i++)
	{
		//echo $countOfAll;
		$percent = round($countOfAll>0?getresultData($result, 0, "count".$i)*100/$countOfAll:0, 2);
		echo "<tr>";
        echo "    <td class='vote_main_td1'>".getresultData($result, 0, "option".$i)."：</td>";
        echo "    <td class='vote_main_td2'><div style='width:$percent%'>$percent%</div></td>";
        echo "    <td class='vote_main_td3'><span>".getresultData($result, 0, "count".$i)."</span>/".$countOfAll.gettext_r("ticket")."</td>";
        echo "</tr>";
	}
	echo "</table>\n";
?>
</td>
  </tr>
  <tr>
    <td height="20px" style="background:url(images/vote_fg5.png) no-repeat"></td>
  </tr>
  <tr>
    <td height="30px" style="background:url(images/vote_fg2.png) repeat-y" align="center" valign="bottom" id="vote_a"><a href="javascript:window.close()">关闭窗口</a> | <a href="/cms">返回首页</a></td>
  </tr>
  <tr>
    <td height="30px" style="background:url(images/vote_fg6.png) no-repeat"></td>
  </tr>
</table>

</body>
</html>
