<?Php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理</title>
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
include "../library/admin.column.php";
$columnid = $_GET ["columnid"];
$action = $_GET ["action"];
$preurl = $_GET ["url"];
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
//检查权限
//得到频道id
$channelid = $columnid;
if($columnid!="0")
{
	//如果不是频道管理
	for(;;)
	{
		$tempid = getcolumnformationBycolumnid($channelid,"parentid");
		if($tempid=="0")
		{
			break;
		}
		$channelid = $tempid;
	}
}
if($functionarray[$channelid]!="2"&&getlogininfo("adminrole")!="0")
{
	//如果不是超管或频道管理员
	die("<script type='text/javascript'>alert('".gettext_r("noRight")."');history.back('-1');</script>\n");
}

?>
<?php

switch ($action) {
	case "delete" :
		$result = getresult ( "select parentid,childcount from I_column where id=" . $columnid );
		$parentid = getresultData ( $result, 0, "parentid" );
		$childcount = getresultData ( $result, 0, "childcount" );
		if ($childcount > 0) {
			echo "<script type='text/javascript'>alert('".gettext_r("haveChildColumn")."');history.back('-1');</script>\n";
			die();
		}
		$result1 = getresult ( "select childcolumn,childcount from I_column where id=" . $parentid );
		$childcolumn = getresultData ( $result1, 0, "childcolumn" );
		$childcount = getresultData ( $result1, 0, "childcount" );
		$childid = explode ( "|", $childcolumn );
		$childcolumn = "";
		$index = 0;
		foreach ( $childid as $id ) {
			if (count ( $childid ) == 1)
				break;
			if ($id == $columnid)
				continue;
			elseif ($id != $columnid && $index ++ == 0)
				$childcolumn .= $id;
			else
				$childcolumn .= ("|" . $id);
		}
		//删除
		getresult("delete from I_article where columnid=".$columnid);
		$return = getresult ( "delete from I_column where id=" . $columnid );
		//更新父栏目参数
		getresult ( "update I_column set childcount=childcount-1, childcolumn='" . $childcolumn . "' where id=" . $parentid );
		if ($return)
		{
			if($parentid==0)
				die ("<script type='text/javascript'>alert('".gettext_r("delete").gettext_r("success")."');parent.location=parent.location;</script>\n");	
			echo "<script type='text/javascript'>alert('".gettext_r("delete").gettext_r("success")."');window.location=\"" . $preurl . "\";</script>\n";
		}
		else
			echo "<script type='text/javascript'>alert('".gettext_r("delete").gettext_r("fail")."');history.back('-1');</script>\n";
		break;
	case "add" :
		//添加栏目
		if ($_POST ["submmit"] == gettext_r("submit")) {
			$columnname = $_POST ["columnname"];
			$keywords = str_replace("'","''",$_POST ["keywords"]);
			$isopen = $_POST ["isopen"];
			$columntemplate = $_POST ["columntemplate"];
			$articletemplate = $_POST ["articletemplate"];
			$searchtemplate = $_POST["searchtemplate"];
			$lang = $_POST["lang"];
			$return = NULL;
			//增加栏目
			$result = getresult ( "select max(id) as maxid from I_column" );
			$newid = getresultData ( $result, 0, "maxid" ) + 1;
			$insertNewcolumnSql =  "insert into I_column(id,columnname,childcount,childcolumn,parentid,keywords,isopen,columntemplate,articletemplate,searchtemplate,lang)";
			$insertNewcolumnSql .= " values ($newid,'$columnname',0,'',$columnid,'$keywords',$isopen,$columntemplate,$articletemplate,$searchtemplate,'$lang')";
			if(!getresult($insertNewcolumnSql))
			{
				echo $insertNewcolumnSql;
				die( "<script type='text/javascript'>alert('".gettext_r("add").gettext_r("fail")."');history.back('-1');</script>\n");
			}
			$result2 = getresult ( "select childcolumn from I_column where id = $columnid" );
			$childcolumn = getresultData($result2,0,"childcolumn");
			$newChildcolumn = "";
			
			if($childcolumn==="")
				$newChildcolumn = $newid;
			else 
				$newChildcolumn = $childcolumn."|".$newid;
				
			$updateparentColumnSql = "update I_column set childcount=childcount+1 , childcolumn = '$newChildcolumn' where id = $columnid";
			$return = getresult($updateparentColumnSql);
			//增加栏目//
			if ($return != false) {
				if ($columnid == 0)
					echo "<script type='text/javascript'>alert('".gettext_r("add").gettext_r("success")."');parent.location=parent.location;</script>\n";
				else
					echo "<script type='text/javascript'>alert('".gettext_r("add").gettext_r("success")."');window.location=window.location;</script>\n";
			} else
				echo "<script type='text/javascript'>alert('".gettext_r("add").gettext_r("fail")."');history.back('-1');</script>\n";
		
		}
		//显示填写表单
		echo "<form id=\"form1\" name=\"form1\" method=\"post\" action=\"\" onsubmit=\"return column_form_check()\">\n";
		echo "<table>\n";
		echo "	<tr><td class='label'>".gettext_r("columnName")."：</td><td class='attributeinput'><input type=\"text\" name=\"columnname\" /></td></tr>\n";
		echo "	<tr><td class='label'>".gettext_r("keywords")."：</td><td class='attributeinput'><input type=\"text\" name=\"keywords\" /></td></tr>\n";
		echo "	<tr><td class='label'>".gettext_r("lang")."：</td><td class='attributeinput'><input type=\"text\" name=\"lang\" /></td></tr>\n";
		
		echo "	<tr><td class='label'>".gettext_r("column").gettext_r("template")."：</td><td class='attributeinput'><select name=\"columntemplate\">\n";
		//栏目模板列表
		$columntemplate = getresult ( "select id,templatename from I_template where templatetype=1" );
		while ( list ( $id, $templatename ) = getresultRow ( $columntemplate ) ) {
			echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select></td></tr>\n";
		echo "	<tr><td class='label'>".gettext_r("article").gettext_r("template")."：</td><td class='attributeinput'><select name=\"articletemplate\">\n";
		//文章模板列表
		$articletemplate = getresult ( "select id,templatename from I_template where templatetype=2" );
		while ( list ( $id, $templatename ) = getresultRow ( $articletemplate ) ) {
			echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select></td></tr>\n";
		
		echo "	<tr><td class='label'>".gettext_r("search").gettext_r("template")."：</td><td class='attributeinput'><select name=\"searchtemplate\">\n";
		//搜索模板列表
		$articletemplate = getresult ( "select id,templatename from I_template where templatetype=4" );
		while ( list ( $id, $templatename ) = getresultRow ( $articletemplate ) ) {
			echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select></td></tr>\n";
		
		echo "	<tr><td class='label'>".gettext_r("ifLock")."：</td><td>".gettext_r("yes")."<input type=\"radio\" value=\"0\" name=\"isopen\"/>".gettext_r("no")."<input type=\"radio\" value=\"1\" name=\"isopen\"  checked=\"checked\" /></td></tr>\n";
		echo "	<tr><td></td><td><input type=\"submit\" value=\"".gettext_r("submit")."\" name=\"submmit\" /><input type=\"reset\" value=\"".gettext_r("cancle")."\" /></td></tr>";
		echo "</table>\n";
		echo "</form>\n";
		break;
	case "modify" :
		if ($_POST ["submmit"] == gettext_r("submit")) {
			$columnname = $_POST ["columnname"];
			//$columnnameen = $_POST ["columnnameen"];
			$keywords = str_replace("'","''",$_POST ["keywords"]);
			$isopen = $_POST ["isopen"];
			$columntemplate = $_POST ["columntemplate"];
			$articletemplate = $_POST ["articletemplate"];
			$searchtemplate = $_POST ["searchtemplate"];
			$lang = $_POST ["lang"];
			
			$return = getresult ( "update I_column set columnname='$columnname',keywords='$keywords',isopen=$isopen,columntemplate=$columntemplate,articletemplate=$articletemplate,searchtemplate=$searchtemplate,lang='$lang' where id=$columnid" );
			if ($return)
				echo "<script type='text/javascript'>alert('".gettext_r("update").gettext_r("success")."');window.location=\"" . $preurl . "\";</script>\n";
			else
				echo "<script type='text/javascript'>alert('".gettext_r("update").gettext_r("fail")."');history.back('-1');</script>\n";
		
		}
		
		//显示填写表单
		$result = getresult ( "select * from I_column where id=" . $columnid );
		$columnname = getresultData ( $result, 0, "columnname" );
		$keywords = getresultData ( $result, 0, "keywords" );
		$columntemplateid = getresultData ( $result, 0, "columntemplate" );
		$articletemplateid = getresultData ( $result, 0, "articletemplate" );
		$searchtemplateid = getresultData ( $result, 0, "searchtemplate" );
		$isopen = getresultData ( $result, 0, "isopen" );
		$lang = getresultData( $result, 0, "lang" );
		
		echo "<form id=\"form1\" name=\"form1\" method=\"post\" action=\"\">\n";
		echo "<table>\n";
		echo "	<tr><td class='label'>".gettext_r("columnName")."：</td><td class='attributeinput'><input value='" . $columnname . "' type=\"text\" name=\"columnname\" /></td></tr>\n";
		echo "	<tr><td class='label'>".gettext_r("keywords")."：</td><td class='attributeinput'><input  value='" . $keywords . "' type=\"text\" name=\"keywords\" /></td></tr>\n";
		echo "	<tr><td class='label'>".gettext_r("lang")."：</td><td class='attributeinput'><input value='" . $lang . "' type=\"text\" name=\"lang\" /></td></tr>\n";
		
		echo "	<tr><td class='label'>".gettext_r("column").gettext_r("template")."：</td><td class='attributeinput'><select name=\"columntemplate\">\n";
		//栏目模板列表
		$columntemplatelist = getresult ( "select id,templatename from I_template where templatetype=1" );
		while ( list ( $id, $templatename ) = getresultRow ( $columntemplatelist ) ) {
			if ($id == $columntemplateid)
				echo "<option selected=\"selected\" value='$id'>$templatename</option>\n";
			else
				echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select></td></tr>\n";
		echo "	<tr><td class='label'>".gettext_r("article").gettext_r("template")."：</td><td class='attributeinput'><select name=\"articletemplate\">\n";
		//文章模板列表
		$articletemplatelist = getresult ( "select id,templatename from I_template where templatetype=2" );
		while ( list ( $id, $templatename ) = getresultRow ( $articletemplatelist ) ) {
			if ($id == $articletemplateid)
				echo "<option selected=\"selected\" value='$id'>$templatename</option>\n";
			else
				echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select></td></tr>\n";
		
		echo "	<tr><td class='label'>".gettext_r("search").gettext_r("template")."：</td><td class='attributeinput'><select name=\"searchtemplate\">\n";
		//搜索模板列表
		$articletemplatelist = getresult ( "select id,templatename from I_template where templatetype=4" );
		while ( list ( $id, $templatename ) = getresultRow ( $articletemplatelist ) ) {
			if ($id == $articletemplateid)
				echo "<option selected=\"selected\" value='$id'>$templatename</option>\n";
			else
				echo "<option value='$id'>$templatename</option>\n";
		}
		echo "  </select></td></tr>\n";
		
		echo "	<tr><td class='label'>".gettext_r("ifLock")."：</td><td>";
		if ($isopen == 0)
			echo gettext_r("yes")."<input type=\"radio\" value=\"0\" name=\"isopen\" checked=\"checked\" />".gettext_r("no")."<input type=\"radio\" value=\"1\" name=\"isopen\" />";
		else
			echo gettext_r("yes")."<input type=\"radio\" value=\"0\" name=\"isopen\" />".gettext_r("no")."<input type=\"radio\" value=\"1\" name=\"isopen\"  checked=\"checked\" />";
		echo "</td></tr>\n";
		echo "	<tr><td></td><td><input type=\"submit\" value=\"".gettext_r("submit")."\" name=\"submmit\" /><input type=\"reset\" onclick=\"history.back(-1)\" value=\"".gettext_r("back")."\" /></td></tr>";
		echo "</table>\n";
		echo "</form>\n";
		break;
	//列出栏目列表，对其进行操作
	default :
		//begin
		echo "<div id='navigation'>".gettext_r("quickLink")."：";
		if ($columnid != 0)
			echo "<a href=\"admin_column.php?action=add&columnid=" . $columnid . "\">".gettext_r("add").gettext_r("column")."</a>\n";
		else
			echo "<a href=\"admin_column.php?action=add&columnid=" . $columnid . "\">".gettext_r("add").gettext_r("channel")."</a>\n";
		echo "</div>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
		echo "<tr class='header'>\n";
		echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
		echo "<td align='center'>".gettext_r("columnName")."</td>\n";
		echo "<td align='center' width='400'>".gettext_r("operate")."</td>\n";
		echo "</tr>\n";
		showColumnstructure ( $columnid );
		echo "</table>\n";
	/*echo "<a href=\"admin_column.php?action=add&columnid=".$columnid."\">添加子栏目</a>\n";
			
			$childColumn = mssql_init("getchildColumn");
			mssql_bind($childColumn, "@id", stripslashes($columnid), SQLINT1, false, false, 1);
			$result = mssql_execute($childColumn,false);
			echo "<table>\n";
				echo "<tr>\n";
				echo "<td>编号</td>\n";
				echo "<td>名称</td>\n";
				echo "<td>操作</td>\n";
				echo "</tr>\n";
			do
			{
				while($row = getresultArray($result))
					{
						$id = $row["id"];
						$childColumnname = $row["columnnamezh"];
						$childCount = $row["childcount"];
						echo "<tr>\n";
						echo "<td>".$id."</td>\n";
						echo "<td>".$childColumnname."</td>\n";
						echo "<td>";
						
						echo "<a href=\"admin_column.php?action=modify&columnid=".$id."\">修改栏目参数</a>\n";
						echo "<a href=\"admin_column.php?action=delete&columnid=".$id."\">删除</a>\n";
						//如果有子栏目则显示管理子栏目
						if($childCount > 0)
							echo "<a href=\"admin_column.php?columnid=".$id."\">管理子栏目($childCount)</a>\n";
						else
							echo "<a href=\"#\">管理子栏目($childCount)</a>\n";
						echo "</td>";
						echo "</tr>\n";
					}
			}while(mssql_next_result($result));*/
//end
}
?>
</body>
</html>
