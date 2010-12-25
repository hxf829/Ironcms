<?php
	require "en.php";
	if($_SESSION["adminlang"]==null || $_SESSION["frontlang"]==null || $_SESSION["adminlang"]=="" || $_SESSION["frontlang"]=="")
	{
		echo $_SESSION["adminlang"];
		//从数据库中读取配置信息，初始化语言环境
		$result = getresult("select * from I_siteconfig");
		if(getresultNumrows($result) < 1)
		{
			//如果出错转到错误页面
			die("<script type='text/javascript'>window.location='error.html'</script>");
		}
		$row = getresultArray($result);
		$_SESSION["adminlang"] = $row["adminlang"];
		$_SESSION["frontlang"] = $row["frontlang"];
	}
	//已做过初始化工作，这里不做处理
	preg_match("/[a-zA-Z\-]+/", $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matchs);
	$language = strtolower($matchs[0]);
	//echo $language;
	if(strpos($_SERVER["URL"],"/admin/") > 0)
	{
		//管理页面
		if($_SESSION["adminlang"] == "Auto")
		{	
			if(is_file(getroot()."/lang/".$language.".php"))
			{
				require $language.".php";
			}
		}
		else
		{
			if(is_file(getroot()."/lang/".$_SESSION["adminlang"].".php"))
				require $_SESSION["adminlang"].".php";
		}
	}
	else
	{
		//前台页面
		if($_SESSION["frontlang"] == "Auto")
		{
			if(is_file(getroot()."/lang/".$language.".php"))	
				require $language.".php";
		}
		else
		{
			if(is_file(getroot()."/lang/".$_SESSION["frontlang"].".php"))
				require $_SESSION["frontlang"].".php";
		}
	}
	//以下代码支持栏目及相关页面国际化操作
	if(preg_match("/.*(showcolumn|showarticle|showcomment)\.php.*/", $_SERVER['URL'], $matchs) > 0)
	{
		$columnid = -1;
		if($_GET["articleid"] != NULL && $_GET["articleid"] != "")
		{
			$columnid = getcolumnformation($_GET["articleid"], "id");
		}
		if($_GET["columnid"] != NULL && $_GET["columnid"] != "")
		{
			$columnid = $_GET["columnid"];
		}
		$columnLanguage = trim(getcolumnformationBycolumnid($columnid,"lang"));
		//栏目的语言如果为Auto，则继承父栏目语言，如果没有父栏目，则继承前台页面语言	
		while($columnLanguage == "Auto")
		{
			$parentid = (int)getcolumnformationBycolumnid($columnid,"parentid");
			if($parentid == 0)
			{
				//已经查询至一级栏目
				break;
			}
			if($parentid > 0)
			{
				$columnid = $parentid;
				$columnLanguage = trim(getcolumnformationBycolumnid($columnid,"lang"));
			}
		}
		
		if($columnLanguage != "Auto" && $columnLanguage!="" && is_file(getroot()."/lang/".$columnLanguage.".php"))
			require $columnLanguage.".php";
	}
?>