<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自定义字段管理</title>
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
		include_once "../library/basefunction.php";
		include_once "../lang/envinit.php";
		include "../library/admin.field.php";
		$functionarray = translatefunctioncode($_SESSION["functioncode"]);
		$columnid = $_GET["columnid"];
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		//$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
?>
<?php
	switch($action)
	{
		//删除自定义字段
		case "delete":
			$fieldid = $_GET["fieldid"];
			$result = getresult("select * from I_field where id=$fieldid");
			$fieldname = getresultData($result,0,"fieldname");
			$deletearticlefield = "ALTER TABLE I_article DROP $fieldname";
			if(getresult("delete from I_field where id=".$_GET["fieldid"])&&getresult($deletearticlefield))
			{
				echo "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("success")."');window.location=\"$preurl\";</script>";
			}
			else
			{
				echo "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("fail")."');window.location=\"$preurl\";</script>";
			}
			break;
		//添加自定义字段	
		case "add"   :
		    if($_POST["submit"]==gettext_r("submit"))
		    {
		        //存储自定义字段
				$fieldname = "sdel_".trim($_POST["fieldname"]);//加“sdel_”表示自定义字段
				$info = trim($_POST["info"]);
				$datatype = trim($_POST["datatype"]);
				$insertsql = "insert into I_field(columnid,fieldname,info,datatype) value($columnid,'".$fieldname."','".$info."','".$datatype."')";
				if($datatype=="double")
				{
					$addarticleField = "ALTER TABLE I_article ADD $fieldname $datatype";
				}
				else
				{
					$addarticleField = "ALTER TABLE I_article ADD $fieldname $datatype CHARACTER SET utf8 COLLATE utf8_general_ci";
				}
				//已经存在此字段
				//die( $addarticleField);
				if(getresultNumrows(getresult("select * from I_field where fieldname='".$fieldname."'"))>0)
				{
					die("<script type='text/javascript'>alert('".gettext_r("fieldAlreadyExist")."');history.back('-1');</script>\n");
				}
					
				if(getresult($insertsql)&&getresult($addarticleField))
				{
					die("<script type='text/javascript'>alert(\"".gettext_r("add").gettext_r("success")."\");window.location='admin_field.php?columnid=$columnid'</script>");
				}
				else
				{
					die("<script type='text/javascript'>alert(\"".gettext_r("add").gettext_r("fail")."\");history.back(-1)</script>");
				}
				
		    }
?>
<form action="" method="post">
<table width="100%">
  <tr>
	<td class='label' width="150px"><?php echo gettext_r("field").gettext_r("name"); ?>：</td>
    <td>【#sdel_<input type="text" name="fieldname" />】</td>
  </tr>
  <tr>
	<td class='label'><?php echo gettext_r("field").gettext_r("explain"); ?>：</td>
    <td><input type="text" name="info" /></td>
  </tr>
  <tr>
  	<td class='label'><?php echo gettext_r("data").gettext_r("type"); ?>：</td>
	<td><select name="datatype"><option value="double"><?php echo gettext_r("float"); ?></option><option value="varchar(200)"><?php echo gettext_r("text"); ?></option></select></td>
  </tr>
  <tr>
  	<td></td>
	<td><input type="submit" name="submit" value="<?php echo gettext_r("submit"); ?>" /><input type="reset" value="<?php echo gettext_r("cancle"); ?>" /></td>
  </tr>
</table>
</form>
<?php
		break;
		//修改自定义字段
		case "modify":
 			$fieldid = trim($_GET["fieldid"]);
		    $field = getresult("select * from I_field where id=$fieldid");
			//echo "select * from I_field where id=$field";
	        if($_POST["submit"]==gettext_r("submit"))
		    {
		        //修改自定义字段
				$info = trim($_POST["info"]);
				$insertsql = "update I_field set info='".$info."' where id=$fieldid";
				//echo $insertsql;
				if(!getresult($insertsql))
				{
					die("<script type='text/javascript'>alert(\"".gettext_r("update").gettext_r("fail")."\");history.back(-1)</script>");
				}
				else
				{
					die("<script type='text/javascript'>alert(\"".gettext_r("update").gettext_r("success")."\");window.location='admin_field.php?columnid=$columnid'</script>");
				}
		    }
?>
<form action="" method="post">
<table width="100%">
  <tr>
	<td class='label' width="150px"><?php echo gettext_r("field").gettext_r("name"); ?>：</td>
    <td><input type="text" disabled="disabled" name="fieldname" value="【#<?php echo getresultData($field,0,"fieldname") ?>】" /></td>
  </tr>
  <tr>
	<td class='label'><?php echo gettext_r("field").gettext_r("explain"); ?>：</td>
    <td><input type="text" name="info" value="<?php echo getresultData($field,0,"info") ?>" /></td>
  </tr>
  <tr>
  	<td class='label'><?php echo gettext_r("data").gettext_r("type"); ?>：</td>
	<td><select name="datatype"><option><?php echo getresultData($field,0,"datatype")=="double"?gettext_r("float"):gettext_r("text") ?></option></select></td>
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
			echo "<div id='navigation'>".gettext_r("quickLink")."：";
			
			echo "<a href=\"admin_field.php?action=add&columnid=".$columnid."\">".gettext_r("add").gettext_r("field")."</a>\n";
			
			echo "</div>";
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='50'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center' width='140'>".gettext_r("name")."</td>\n";
			echo "<td align='center' width='140'>".gettext_r("explain")."</td>\n";
			echo "<td align='center'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			showfield($columnid);
			echo "</table>\n";
			echo "<div style='height:5px;'></div>";
	}
?>
</body>
</html>
