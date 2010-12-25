<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>调查管理</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				liststyle_mousechange();
				voteoptioncountchange();
			}
		);
</script>
</head>
<body>
<?php
		include "../conn.php";
		include_once '../library/basefunction.php';
		include_once "../lang/envinit.php";
		include "../library/admin.article.php";
		$functionarray = translatefunctioncode($_SESSION["functioncode"]);
		$voteid = $_GET["voteid"];
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		//$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
		$functionarray = translatefunctioncode($_SESSION["functioncode"]);
		if($functionarray["vote"]!="1"&&getlogininfo("adminrole")!="0")
			die(gettext_r("noRgith"));
?>
<?php
	switch($action)
	{
		case "add":
			if($_POST["submit"]==gettext_r("submit"))
			{
				$type = $_POST["type"];
				$title = $_POST["title"];
				$attrcount = $_POST["attrcount"];
				
				$adminid = getlogininfo("adminid");
				$query1 = "insert into I_vote(adminid,title,type,attrcount";
				$query2 = " values($adminid,'$title',$type,$attrcount";
				
				for($i=1;$i<$attrcount+1;$i++)
				{
					$temp = trim($_POST["option$i"]);
					$query1 .= ",option$i";
					$query2 .= ",'$temp'";
				}
				$query1 .= ")";
				$query2 .= ")";
				if(!getresult($query1.$query2))
				    die("<script type='text/javascript'>alert('".gettext_r("add").gettext_r("fail")."');window.location='admin_vote.php';</script>");
				else 
				    die("<script type='text/javascript'>alert('".gettext_r("add").gettext_r("success")."');window.location='admin_vote.php';</script>");
			}
			echo "<form id='form1' name='form1' action='' method='post' onsubmit='vote_form_check()'>";
			echo "<table cellspacing='0' cellpadding='3' border='1' bordercolor='#FFFFFF' style='border-collapse:collapse'>";
			echo "<tr>";
			echo "<td class='label'>".gettext_r("vote").gettext_r("config")."：</td>";
			echo "<td>";
			echo "<input type='radio' checked='true' value='0' name='type'>".gettext_r("singleChoice")."　<input type='radio' name='type' value='1'>".gettext_r("multipleChoice")."";
			echo "　　".gettext_r("choice").gettext_r("count")."(".gettext_r("mostChoiceCount").")<select name='attrcount'>";
			for($i=1;$i<7;$i++)
			{
				if($i==6)
					echo "<option selected='selected' value='$i'>$i</option>";
				else
					echo "<option value='$i'>$i</option>";
			}
			echo "</select>";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class='label' width='80px'>".gettext_r("vote").gettext_r("title")."：</td>";
			echo "<td><input type='text' name='title' style='width:260px'/></td>";
			echo "</tr>";
			for($i=1;$i<7;$i++)
			{
				echo "<tr id='list$i'>";
				echo "<td class='label'>".gettext_r("choice")."$i ：</td>";
				echo "<td><input type='text' name='option$i' style='width:260px'/></td>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td></td>";
			echo "<td><input type='submit' name='submit' value='".gettext_r("submit")."'>　<input type='reset' value='".gettext_r("cancle")."'></td>";
			echo "</tr>";
			echo "</table>";
			break;
		case "modify":
			if($_POST["submit"]==gettext_r("submit"))
			{
				$type = $_POST["type"];
				$title = $_POST["title"];
				$attrcount = $_POST["attrcount"];
				
				$adminid = getlogininfo("adminid");
				$query1 = "update I_vote set adminid=$adminid,title='$title',type=$type,attrcount=$attrcount";
		
				for($i=1;$i<$attrcount+1;$i++)
				{
					$temp = trim($_POST["option$i"]);
					$query1 .= ",option$i='$temp'";
				}
				$query1 .= " where id = $voteid";

				if(!getresult($query1))
				    die("<script type='text/javascript'>alert('".gettext_r("update").gettext_r("fail")."');window.location='admin_vote.php';</script>");
				else 
				    die("<script type='text/javascript'>alert('".gettext_r("update").gettext_r("success")."');window.location='admin_vote.php';</script>");
			}
			$result = getresult("select * from I_vote where id = $voteid");

			$attrcount = getresultData($result,0,"attrcount");
			echo "<form id='form1' name='form1' action='' method='post' onsubmit='vote_form_check()'>";
			echo "<table cellspacing='0' cellpadding='3' border='1' bordercolor='#FFFFFF' style='border-collapse:collapse'>";
			echo "<tr>";
			echo "<td class='label'>".gettext_r("vote").gettext_r("config")."：</td>";
			echo "<td>";
			if(getresultData($result,0,"type")=="0")
			{
				echo "<input type='radio' checked='true' value='0' name='type'>".gettext_r("singleChoice")."　<input type='radio' name='type' value='1'>".gettext_r("multipleChoice");
				echo "　　".gettext_r("choice").gettext_r("count")."(".gettext_r("mostChoiceCount").")<select name='attrcount'>";
			}
			else
			{
				echo "<input type='radio' value='0' name='type'>".gettext_r("singleChoice")."　<input type='radio' checked='true' name='type' value='1'>".gettext_r("multiplChoice");
				echo "　　".gettext_r("choice").gettext_r("count")."(".gettext_r("mostChoiceCount").")<select name='attrcount'>";
			}
			for($i=1;$i<7;$i++)
			{
				if($i==$attrcount)
					echo "<option selected='selected' value='$i'>$i</option>";
				else
					echo "<option value='$i'>$i</option>";
			}
			echo "</select>";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class='label' width='80px'>".gettext_r("vote").gettext_r("title")."：</td>";
			echo "<td><input type='text' name='title' value='".getresultData($result,0,"title")."' style='width:260px'/></td>";
			echo "</tr>";
			for($i=1;$i<7;$i++)
			{
				if($i>$attrcount)
				{
					echo "<tr id='list$i' style='display:none'>";
					echo "<td class='label'>".gettext_r("choice")."$i ：</td>";
					echo "<td><input type='text' name='option$i' value='".getresultData($result,0,"option".$i)."' style='width:260px'/></td>";
					echo "</tr>";
				}
				else
				{
					echo "<tr id='list$i'>";
					echo "<td class='label'>".gettext_r("choice")."$i ：</td>";
					echo "<td><input type='text' name='option$i' value='".getresultData($result,0,"option".$i)."' style='width:260px'/></td>";
					echo "</tr>";
				}
			}
			echo "<tr>";
			echo "<td></td>";
			echo "<td><input type='submit' name='submit' value='".gettext_r("submit")."'>　<input type='button' onclick='history.back(-1)' value='".gettext_r("back")."'></td>";
			echo "</tr>";
			echo "</table>";
			break;
		case "delete":
			if(!getresult("delete from I_vote where id=".$_GET["voteid"]))
				echo "<script type=\"text/javascript\">alert('".gettext_r("update").gettext_r("fail")."');window.location=\"$preurl\";</script>";
			else
				echo "<script type=\"text/javascript\">alert('".gettext_r("update").gettext_r("success")."');window.location=\"$preurl\";</script>";
			break;
		case "details":
			$result = getresult("select * from I_vote where id = $voteid");

			$attrcount = getresultData($result,0,"attrcount");
			echo "<table cellspacing='0' cellpadding='3' border='1' bordercolor='#FFFFFF' style='border-collapse:collapse'>";
			echo "<tr>";
			echo "<td class='label'>".gettext_r("vote").gettext_r("config")."：</td>";
			echo "<td>";
			if(getresultData($result,0,"type")=="0")
			{
				echo "<input type='radio'  disabled='disabled' checked='true' value='0' name='type'>".gettext_r("singleChoice")."　<input type='radio'  disabled='disabled' name='type' value='1'>".gettext_r("multipleChoice");
			}
			else
			{
				echo "<input type='radio' value='0'  disabled='disabled' name='type'>".gettext_r("singleChoice")."　<input type='radio' checked='true' name='type'  disabled='disabled' value='1'>".gettext_r("multipleChoice");
			}
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td class='label' width='80px'>".gettext_r("vote").gettext_r("title")."：</td>";
			echo "<td><input type='text' name='title' value='".getresultData($result,0,"title")."' style='width:260px'/></td>";
			echo "</tr>";
			for($i=1;$i<$attrcount+1;$i++)
			{
				echo "<tr id='list$i'>";
				echo "<td class='label'>".gettext_r("choice")."$i ：</td>";
				echo "<td><input  disabled='disabled' type='text' name='option$i' value='".getresultData($result,0,"option".$i)."' style='width:260px'/> ".gettext_r("ticket").gettext_r("count").":<b>".getresultData($result,0,"count".$i)."</b></td>";
				echo "</tr>";

			}
			echo "<tr>";
			echo "<td cosplan='2'><input type='button' onclick='history.back(-1)' value='".gettext_r("back")."'/></td>";
			echo "</tr>";
			
			echo "</table>";
			break;
		default:
			echo "<div id='navigation'>".gettext_r("quickLink")."：";
			echo "<a href=\"admin_vote.php?action=add\">".gettext_r("add").gettext_r("vote")."</a>\n";
			echo "</div>";
			
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='40'>".gettext_r("checkIn")."</td>\n";
			echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center'>".gettext_r("title")."</td>\n";
			echo "<td align='center' width='300'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			
			$adminid = getlogininfo("adminid");
			if(getlogininfo("adminrole")==="0")
				$result = getresult("select * from I_vote");
			else
				$result = getresult("select * from I_vote where adminid=$adminid");
			if(getresultNumrows($result)<1)
			{
				echo "<tr class='list'>\n";
				echo "<td colspan='4' align='center'>".gettext_r("haveNot").gettext_r("vote")."</td>";
				echo "</tr>";
			}
			while($row = getresultArray($result))
			{
				echo "<tr class='list'>\n";
				echo "<td align='center'><input type='checkbox' name='list' value='".$row["id"]."' /></td>";
				echo "<td>　".$row["id"]."</td>";
				echo "<td>　".$row["title"]."</td>";
				echo "<td align='center'>";
				echo "<a href='admin_vote.php?action=details&voteid=".$row["id"]."'>".gettext_r("see").gettext_r("result")."</a> | <a href='admin_vote.php?action=modify&voteid=".$row["id"]."'>".gettext_r("update")."</a> | <a href='#' onclick=\"getvotecode(".$row["id"].")\">".gettext_r("getInvokeCode")."</a>";
				echo "</td>";
				echo "</tr>";
			}
			
			echo "</table>\n";
			echo "<div style='height:5px;'></div>";
			echo "<input type='checkbox' id='checkall' onclick='checkall()' value='全选' /><span>".gettext_r("checkAll")."　　</span> ";
			echo "<input type='button' onclick=\"deleteall('admin_vote.php')\" value='".gettext_r("deleteAll")."' />";
	}
?>
</body>
</html>
