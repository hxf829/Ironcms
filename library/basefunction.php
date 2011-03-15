<?php
//得到文章id为$articleid的所属栏目的$attribute属性值
function getcolumnformation($articleid, $attribute)
{
	$result = getresult("select * from I_article where id=".$articleid);
	$columnid = getresultData($result, 0, "columnid");
	$result = getresult("select * from I_column where id=".$columnid);
	return getresultData($result, 0, $attribute);
}
//得到文章id的属性值
function getarticleinfo($articleid, $attribute)
{
	if($articleid==NULL)
	{
		return "";
	}
	$result = getresult("select * from I_article where id=".$articleid);
	return getresultData($result, 0, $attribute);
}
//得到栏目id为$columnid的$attribute属性值
function getcolumnformationBycolumnid($columnid, $attribute)
{
    $result = getresult("select * from I_column where id=".$columnid);
	return getresultData($result, 0, $attribute);
}
//用于在显示栏目结构时对如不同层次的栏目显示不同的前导空格
function space($a)
{
	$space = "";
	while($a)
	{
		$space .= "　";
		if($a == 1)
			$space .= "┖";
		$a--;
	}
	return $space;
}
//将将要插入到数据库中的字串中的“'”和“"”转换为数据库转义序列
function transbadchar($string)
{
	$string = str_replace("\'","''",$string);//消除单引号的bug
	$string = str_replace("\\\"", '"', $string);//消除双引号bug
	return $string;
}
//得到登录信息，$attribute为所要得到的信息名称
function getlogininfo($attribute)
{
	$return = $_COOKIE[$attribute]!=NULL?$_COOKIE[$attribute]:$_SESSION[$attribute];
	//echo $_SESSION[$attribute].$_COOKIE[$attribute];
	if($return != NULL)
		return $return;
	else
		return "notdefined";
}
//转化session中保存的权限序列为访问性更好的数组形式
function translatefunctioncode($functioncode)
{
	$returnfunctioncode = NULL;
	$tempstring1 = explode(",", $functioncode);
	foreach($tempstring1 as $var1)
	{
		$tempstring2 = explode("|", $var1);
		$returnfunctioncode[$tempstring2[0]] = $tempstring2[1];
	}
	return $returnfunctioncode;
	/*print_r($returnfunctioncode);
	foreach($returnfunctioncode as $a => $b)
	{
		echo $a."=>>".$b."<br>";
	}*/
}
//得到安装目录
function getroot()
{
    $siteroot = dirname(__FILE__);
    for(;;)
    {
        $tempdir = $siteroot;
        //echo $tempdir;
        str_replace('\\', '/', $tempdir);
        if(file_exists($siteroot."/siteroot"))//siteroot是放在网站根目录下的一个标记文件
        {
            return str_replace('\\', '/', $tempdir);
        }
        else 
        $siteroot = dirname($siteroot);
    }
}
//得到网站安装域名
function getDomain()
{
	$siteconfig = getresult("select * from I_siteconfig limit 0,1");
	return getresultData($siteconfig, 0, "domain");
}
//得到程序所在域名目录
function getPathinDomain()
{
	$dir = getDomain();
	$dir = str_replace("http://".$_SERVER['HTTP_HOST'],"",$dir);
	if(substr($dir,0,1)!="/")
		$dir = "/".$dir;
	if(substr($dir,strlen($dir)-1,1)=="/")
		$dir = substr($dir,0,strlen($dir)-1);
	return $dir;
}
//echo getPathinDomain();
//得到当前页面的路径，即网站当前位置
function getPath()
{
	$siteconfig = getresult("select * from I_siteconfig limit 0,1");
	$path = "";
	$articleid = $_GET["articleid"];
	$columnid = $_GET["columnid"];

	if($articleid != NULL&&$articleid != "")
	{
		//文章页
		//得到栏目串再加上”-正文“
		$tempcolumnid = getcolumnformation($articleid, "id");//文章所在栏目
		for(;;)
		{
			if($tempcolumnid!="0")
			{
				//echo $tempcolumnid."|";
				//如果有父栏目，则将其加到当前$path的前面
				if($path=="")
					$path = "<a href='showcolumn.php?columnid=".$tempcolumnid."'>".getcolumnformationBycolumnid($tempcolumnid,"columnname")."</a>".$path;
				else
					$path = "<a href='showcolumn.php?columnid=".$tempcolumnid."'>".getcolumnformationBycolumnid($tempcolumnid,"columnname")."</a>&gt;&gt;".$path;
			}
			else
				break;
			$tempcolumnid = getcolumnformationBycolumnid($tempcolumnid,"parentid");
		}
		return "<a href=\"".getresultData($siteconfig, 0, "domain")."\">".gettext_r("home")."</a>&gt;&gt;".$path;
	}
	elseif($columnid != NULL&&$columnid != "")
	{
		//栏目页
		//得到栏目串的链接
		$tempcolumnid = $columnid;//当前栏目id
		$path = getcolumnformationBycolumnid($tempcolumnid,"columnname");
		for(;;)
		{
			$tempcolumnid = getcolumnformationBycolumnid($tempcolumnid,"parentid");
			if($tempcolumnid!="0")
			{
				//如果有父栏目，则将其加到当前$path的前面
				$path = "<a href='showcolumn.php?columnid=".$tempcolumnid."'>".getcolumnformationBycolumnid($tempcolumnid,"columnname")."</a>&gt;&gt;".$path;
			}
			else
				break;
		}
		return "<a href=\"".getresultData($siteconfig, 0, "domain")."\">".gettext_r("home")."</a>&gt;&gt;".$path;
	}
	else
	{
		//未知页面
		return gettext_r("home");
	}
}
//从栏目id得到频道id
function getChanelidByColumnid($columnid)
{
	$tempcolumnid = $columnid;
	$chanelId = -1;
	for(;;)
	{
		if($tempcolumnid!="0")
		{
			$chanelId = $tempcolumnid;	
			$tempcolumnid = getcolumnformationBycolumnid($tempcolumnid,"parentid");
		}
		else
			break;
	}
	return $chanelId;
}
//调出子栏目串函数
function getchildcolumnid($columnid, &$childidstring, $index=0)
{
	if($index==0)
		$childidstring = $columnid;
	$query = "select childcolumn from I_column where id=$columnid";
	$result = getresult($query);
	$count = getresultNumrows($result);
	if($count > 0)
	{
		$childColumnId = getresultData($result,0,"childcolumn");
		//没有子栏目即返回
		//echo $childColumnId."<br>";
		if(($childColumnId == NULL)||($childColumnId == 0)||($childColumnId == ""))
		{
			return false;
		}
		$childId = explode("|",$childColumnId);
		foreach($childId as $id)
		{
			$childidstring.=(",".$id);
			//echo $childidstring;
			getchildcolumnid($id , $childidstring, $index+1);
		}
	}
	else
		return false;
}
//国际化函数
function gettext_r($valueName)
{
	global $_lang;
	/*
	eval("global $".$valueName.";");
	$value = "";
	eval("\$value = \"$".$valueName."\";");
	return $value;
	*/
	return $_lang[$valueName];
}
//读取catch
function readcache()
{
	//如果处在debug模式，则不读缓存
	global $_DEBUG;
	global $language;
	if($_DEBUG==true)
		return;
		
	//如果缓存中存在，则直接输出缓存
	$specialletters = array(":", "/", "&", "?", ".");
	$cachefilepath = getroot()."/temp/".str_replace($specialletters, "", $_SERVER['REQUEST_URI']).".cache";
	if(file_exists($cachefilepath))
	{
		$cachetime = time() - filemtime($cachefilepath);
		if($cachetime < 30)//过时时间
			die(file_get_contents($cachefilepath));
	}
}
//创建缓存
function buildcache($content)
{
	global $language;
	$specialletters = array(":", "/", "&", "?", ".");
	$cachefilepath = getroot()."/temp/".str_replace($specialletters, "", $_SERVER['REQUEST_URI']).".cache";
	if(!file_exists(getroot()."/temp/"))
		mkdir(getroot()."/temp/");	
	$fp = fopen($cachefilepath, "w");
	fwrite($fp, $content);
	fclose($fp);
}
?>