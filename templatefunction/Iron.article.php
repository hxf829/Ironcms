<?php
/*调用格式
*【articlelist(columnid,articlenum,titlelen,ifpage,timetype)】
*<h2>【#title】</h2>
*<b>【#time】</b>
*【/articlelist】
* 调用示例
*【articlelist(1,6,2,0,1)】
*<tr>
*	<td>【#title】</td>
*	<td>【#time】</td>
*	<td>【#title】</td>
*	<td>【#time】</td>
*	<td>【#title】</td>
*	<td>【#time】</td>
*	<td>【#title】</td>
*	<td>【#time】</td>
*【/articlelist】
*/
//显示文章列表的一些全局参数
global $id,$author,$time,$source,$title,$notes,$hits,$picurl,$picwidth,$picheight;
//定义分页大小，默认为10
global $pagesize;
$pagesize = 10;

$articleid = $_GET["articleid"];
$columnid = $_GET["columnid"];
//得到网站配置信息
$siteconfig = getresult("select * from I_siteconfig limit 0,1");
//如果参数中有articleid，则得到此文章的信息
$article = getresult("select * from I_article where id=$articleid");
//如果参数中有columnid，则得到此栏目的信息
$column = getresult("select * from I_column where id=$columnid");
//取得页面标题
function getHtmltitle()
{
    global $siteconfig,$article,$column;
    
    if($article&&(getresultData($article,0,"title")!=""))
    {
        return getresultData($article,0,"title");
    }
    elseif($column&&getresultData($column,0,"columnname"))
    {
        return getresultData($column,0,"columnname");
    }
    return getresultData($siteconfig,0,"sitename");
}
//得到网站名称
function getSitename()
{
    global $siteconfig,$article,$column;
    return getresultData($siteconfig,0,"sitename");
}
//得到网站关键字
function getSitekeywords()
{
	global $siteconfig;
    return "<meta name=\"Keywords\" content=\"".getresultData($siteconfig,0,"keywords")."\">";
}
//取得版权信息
function getCopyright()
{
    global $siteconfig,$article,$column;
    return getresultData($siteconfig,0,"copyright");
}
//取得logo地址
function getLogo()
{
    global $siteconfig,$article,$column;
    return getresultData($siteconfig,0,"logo");
}
//得到频道导航
function getChanels()
{
    global $siteconfig,$article,$column;
    $result = getresult("select * from I_column where parentid=0");
    $chanels = "";
    while ($row = getresultArray($result))
    {
        $chanels .= "<a target='_blank' href='showcolumn.php?columnid=".$row["id"]."'>".$row["columnname"]."</a>";
    }
    return $chanels;
}
//得到子栏目导航
function getChildcolumnlist()
{
    global $siteconfig,$article,$column,$articleid,$columnid;
    $childcolumn = getresult("select * from I_column where parentid=$columnid");
    //如果没有子栏目则返回空
    if($childcolumn==FALSE||getresultNumrows($childcolumn)<1)
        return "";
    //echo $childcolumn;
    $childcolumnlist = "";
    while ($row = getresultArray($childcolumn))
    {
        $childcolumnlist .= "<a target='_blank' href='showcolumn.php?columnid=".$row["id"]."'>".$row["columnname"]."</a>";
    }
    return $childcolumnlist;
}
//得到栏目名称
function getColumnname()
{
	global $column;
	if(!$column)
		return "";
	return getresultData($column,0,"columnname");
}
//得到栏目页标题
function getArticletitle()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"title");
}
//得到栏目关键字
function getColumnkeywords()
{
	global $siteconfig,$article,$column;
    if($article)
    {
        return "<meta name=\"Keywords\" content=\"".getcolumnformation(getresultData($article,0,"id"),"keywords")."\">";
    }
    elseif($column&&getresultData($column,0,"keywords")!="")
    {
        return "<meta name=\"Keywords\" content=\"".getresultData($column,0,"keywords")."\">";
    }
	//未知地址返回空
    return "";
}
//得到文章内容
function getArticlecontent()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"contents");
}
//得到文章日期
function getAdddate()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"addtime");
}
//得到文章关键字
function getArticlekeywords()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return "<meta name=\"Keywords\" content=\"".getresultData($article,0,"keywords")."\">";
}
//得到文章点击数
function getHits()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"hits");
}
//得到文章作者
function getAuthor()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"author");
}
//得到文章来源
function getSource()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"source");
}
//得到文章缩略图地址
function getPicurl()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"picurl");
}
//得到文章简介
function getNotes()
{
	global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    return getresultData($article,0,"notes");   
}
//得到上一篇文章链接
function getPre()
{
    global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    $result = getresult("select * from I_article where id<$articleid and columnid=".getresultData($article,0,"columnid")." order by id desc limit 0,1");
    if(getresultNumrows($result)<1)
        return "No article!";
    return "<a href='showarticle.php?articleid=".getresultData($result,0,"id")."'>".getresultData($result,0,"title")."</a>";
}
//得到下一篇文章链接
function getNext()
{
    global $siteconfig,$article,$column,$articleid,$columnid;
    if(!$article)
        return "";
    $result = getresult("select * from I_article where id>$articleid and columnid=".getresultData($article,0,"columnid")." order by id asc limit 0,1");
    if(getresultNumrows($result)<1)
        return "No article!";
    return "<a href='showarticle.php?articleid=".getresultData($result,0,"id")."'>".getresultData($result,0,"title")."</a>";
}
//得到评论框
function getCommentform()
{
    return "";
}
//得到页码导航
function getPage($pagesize)
{
    $columnid = $_GET["columnid"];
    if(!isset($columnid)||$columnid=="")
        return "";
	//子栏目字符串
	$childColumnString = "";
	getchildcolumnid($columnid, $childColumnString);
    //页面导航字符串
    $Page = "";
    //从url得到参数
    $currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
    //echo $pagesize;
    //echo $currentpage;
    //echo $pagesize;
    //echo $columnid;
    $tempresult = getresult("select count(*) as countofarticle from I_article where columnid in ($childColumnString)");
    $countofarticle = getresultData($tempresult, 0, "countofarticle");
    //echo "|".$countofarticle;
    if ($countofarticle % $pagesize == 0)
        $allpage = $countofarticle / $pagesize;
    else
        $allpage = floor($countofarticle / $pagesize) + 1;
        //消除文章数为零时显示下一页链接的bug
    if ($countofarticle == 0)
        $allpage += 1;
    //echo "|".$pagesize." ".$currentpage;
    $Page .= gettext_r("total")." <b> " . $allpage . " </b> ".gettext_r("page")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($currentpage == 1)
        $Page .= gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
    else
        $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=1'>".gettext_r("firstPage")."</a> | <a href='showcolumn.php?columnid=$columnid&currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
    $temppage = 1;

    if (($currentpage - 1) < 5)
        while ($temppage <= $currentpage)
        {
            if ($currentpage == $temppage)
            {
                $Page .= "<b>" . $temppage . "</b> ";
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $currentpage)
        {
            if ($currentpage == $temppage)
            {
                $Page .= "<b>" . $temppage . "</b> ";
                $temppage ++;
                continue;
            }
            if ($temppage == 1)
            {
                $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> … ";
                $temppage ++;
                continue;
            }
            if (($currentpage - $temppage) > 3)
            {
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if (($allpage - $currentpage) < 5)
        while ($temppage <= $allpage)
        {
            if ($temppage == 1)
            {
                $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $allpage)
        {
            if ($temppage == $allpage)
            {
                $Page .= " … <a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            if (($temppage - $currentpage) > 3)
            {
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcolumn.php?columnid=$columnid&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if ($currentpage == $allpage)
        $Page .= "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
    else
        $Page .= "| <a href='showcolumn.php?columnid=$columnid&currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='showcolumn.php?columnid=$columnid&currentpage=$allpage'>".gettext_r("lastPage")."</a>";

    return $Page;
}
//初始化一篇文章的信息
function initarticledata($row)
{
    global $id,$author,$time,$source,$title,$notes,$hits,$picurl;
    $id = $row["id"];
    $author = $row["author"];
    $time = $row["addtime"];
    //echo $time."<br><br><br><br><br><br><br><br><br>";
    $source = $row["source"];
    $title = $row["title"];
    $notes = $row["notes"];
    $hits = $row["hits"];
    $picurl = $row["picurl"];    
}
//替换模板中的标签
function getvalue($name,$datatype=0)//$datatype为数据格式化种类
{
	
    global $id,$author,$time,$source,$title,$notes,$hits,$picurl,$picwidth,$picheight;
    if($name=="【#title】")
        return $title;
	elseif($name=="【#time】")
	{
		//echo "haoxuefeng".$datatype;
		if($datatype=="0")//年-月-日
	    	return substr($time,0,10);
		if($datatype=="1")//月-日
	    	return substr(substr($time,0,10),5);
		if($datatype=="2")//月-日 时-分
	    	return substr($time,5,11);
		if($datatype=="3")//时-分
	    	return substr($time,11,5);						
		return $time;
	}
	elseif($name=="【#id】")
	    return $id;
    elseif($name=="【#author】")
	    return $author;
	elseif($name=="【#source】")
	    return $source;
	elseif($name=="【#notes】")
	    return $notes;
	elseif($name=="【#hits】")
	    return $hits;
	elseif($name=="【#pic】"&&$picurl!=""&&$picurl!=null)
	{
		//echo $picwidth."ddddddddddddddddd".$picheight;
	    return "<img width='$picwidth' height='$picheight' src='$picurl'/>";
	}
	elseif($name=="【#picurl】")
	    return $picurl;
	//替换自定义字段标签
	else
	{
		if($name == translateSdefFeildlabel($name))
			return "";
		else
			return translateSdefFeildlabel($name);
	}
}
//字符串中有个相同的关键字，但只替换一个函数
function replace_once($replace,$str,$targetstr)
{
    $tempstr = $str;
    for (;;)
    {
        if(strrpos($tempstr,$replace)<0)
            break;
        $tempindex = strrpos($tempstr,$replace);
        if($tempindex!=false)
        {
            $tempstr = substr($str,0,$tempindex);
        }
        else break;
    }
    $replaceindex = strlen($tempstr);
    //echo$replaceindex;
    //echo $replaceindex."hao";
    $str = substr($str,0,$replaceindex).$targetstr.substr($str,$replaceindex+strlen($replace));
    return $str;
}
//翻译模板中的【articlelist(columnid,articlenum,titlelen,ifpage)】自定义标签
function translateArticlelist($template)
{
	global $pagesize,$picwidth,$picheight;//如果指定页大小，则用用户参数填充$pagesize
	
    //匹配自定义文章列表标签正则
    $flag = "/【articlelist(\([\d\w]*,\d*,\d*,\d*,\d*,\d*,\d*,\d*\))】([\s\S]*?)【\/articlelist】/";
	preg_match_all($flag, $template, $matches,PREG_SET_ORDER);
	//替换所有articlelist标签
	$html = $template;
	//echo $template;
	foreach($matches as $matche)
	{
	    //得到需要循环的部分
    	$str = $matche[2];
    	//得到标签参数参数
    	$parameter = substr($matche[1], 1, strlen($matche[1])-2);
    	$parameter = split(',',$parameter);
    	$columnid = $parameter[0];
    	$articlenum = $parameter[1];
    	$titlelen = $parameter[2];
    	$ifpage = $parameter[3];
		$timetype = $parameter[4];
		//echo $timetype;
		$sorttype = $parameter[5];
		//缩略图的宽和高
		$picwidth = $parameter[6];
		$picheight = $parameter[7];
		$ifshowpic = "";
		if($picwidth!=null&&$picheight!=null&&$picheight!=0&&$picheight!=0)
			$ifshowpic = "picurl<>'' and picurl is not NULL and";
		//定义排序方式的字串		
		if($sorttype=="0")//id降序
			$sortstr = "order by id desc";
		else
			$sortstr = "order by id asc";
    	
    	//如果参数columnid的值为thiscolumn则替换为当前栏目id
    	if($columnid=="columnid"||$columnid=="")
    	    $columnid=$_GET["columnid"];
		
		//栏目子栏目串
		$childColumnString = "";
		getchildcolumnid($columnid, $childColumnString);
		
    	//得到url参数
		$oldpagesize = $pagesize;
    	$pagesize = $articlenum;
    	$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
    	//根据参数从数据库取得数据
    	if($ifpage=="1")
    	    $articlesql = "select *,left(title,$titlelen) as title from I_article where ".$ifshowpic." columnid in ($childColumnString) and ifpass=1 ".$sortstr." limit ".($currentpage-1)*$pagesize.",$pagesize";
    	else
    	    $articlesql = "select *,left(title,$titlelen) as title from I_article where ".$ifshowpic." columnid in ($childColumnString) and ifpass=1  ".$sortstr." limit 0,$articlenum";
    	//echo $articlesql;
    	$result = getresult($articlesql);
    	//匹配循环部分的标签
    	$tag_flag = "/【#[\s\S]*?】/";
    	preg_match_all($tag_flag, $str, $data_tag,PREG_SET_ORDER);
        
    	$tag_index = null;//记录标签循环部分每中标签出现的次数,如果出现第二次，则视为要显示两列数据，依次类推...
    	//将要输出的html代码;
    	$temphtml = ""; 
    	while($row = getresultArray($result))
    	{
    	    $str = $matche[2];
        	foreach($data_tag as $temp)
        	{
               //$tempindex = 0;
               for(;;)
               {
            	    if($tag_index[$temp[0]] < 1)
            	    {
            	        //初始化一篇文章数据
            	        initarticledata($row);
            	        //替换标签
            		    $str = replace_once($temp[0], $str, getvalue($temp[0],$timetype));
            		    //当前匹配标签计数器加1
            		    if(isset($tag_index[$temp[0]]))
            		    {
            		        $tag_index[$temp[0]]++;
            		    }
            		    else 
            		    {
            		        $tag_index[$temp[0]]=1;
            		    }
            		    break;
            	    }
            	    //如果每个循环中有多列，则执行下面的代码
            	    else 
            	    {
            	        //取新文章数据
            	        $row = getresultArray($result);//第二次出现的标签都会引发取得新数据，故产生错误
            	        //初始化数据
            	        initarticledata($row);
            	        //当前匹配标签计数器加1
                		$tag_index = NULL;
            	    }
               }
        	}
			$tag_index = NULL;
        	$temphtml .= $str;
    	}
    	if(trim($temphtml)=="")
    	    $html = str_replace($matche[0],gettext_r("haveNot").gettext_r("article"),$html);
        else 
    	    $html = str_replace($matche[0],$temphtml,$html);
		//echo "||".$ifpage;
		if($ifpage == 0)
		{
			$pagesize = $oldpagesize;
		}
	}
	return $html;
}

//翻译模板中的普通标签
function translateCommonlabel($template)
{
	global $pagesize,$articleid;
    $template = str_replace("【#sitename】",getSitename(),$template);
    $template = str_replace("【#htmltitle】",getHtmltitle(),$template);
    $template = str_replace("【#copyright】",getCopyright(),$template);
	$template = str_replace("【#path】", getPath(), $template);
    $template = str_replace("【#logo】",getLogo(),$template);
    $template = str_replace("【#chanels】",getChanels(),$template);
    $template = str_replace("【#childcolumnlist】",getChildcolumnlist(),$template);
	
	//网站，栏目，文章关键字
	$template = str_replace("【#sitekeywords】",getSitekeywords(),$template);
	$template = str_replace("【#columnkeywords】",getColumnkeywords(),$template);
	$template = str_replace("【#articlekeywords】",getArticlekeywords(),$template);
    
	$template = str_replace("【#columnname】",getColumnname(),$template);
	
	$template = str_replace("【#articleid】",$articleid,$template);
    $template = str_replace("【#articletitle】",getArticletitle(),$template);
    $template = str_replace("【#articlecontent】",getArticlecontent(),$template);
    $template = str_replace("【#date】",getAdddate(),$template);
    $template = str_replace("【#hits】",getHits(),$template);
    $template = str_replace("【#author】",getAuthor(),$template);
	$template = str_replace("【#source】",getSource(),$template);
	$template = str_replace("【#picurl】",getPicurl(),$template);
    $template = str_replace("【#pre】",getPre(),$template);
    $template = str_replace("【#next】",getNext(),$template);
    $template = str_replace("【#notes】",getNotes(),$template);
    $template = str_replace("【#commentform】",getCommentform(),$template);
	
    //替换自定义字段标签
	$template = translateSdefFeildlabel($template);
	
    $template = str_replace("【#showpage】",getPage($pagesize),$template);
    
    return $template;
}
//替换文章标签自定义字段标签
function translateSdefFeildlabel($template)
{
	global $id;//文章id
	$id = $_GET["articleid"]!=NULL?$_GET["articleid"]:$id;
	$columnid = $_GET["columnid"]!=NULL?$_GET["columnid"]:getarticleinfo($_GET["articleid"],"columnid");
	if($columnid==NULL&&$id!=NULL)
	{
		$columnid = getarticleinfo($id,"columnid");
	}
	if(($columnid!=NULL&&$columnid>0)||($id!=NULL&&$id>0))
	{
		//如果栏目id为空或者小于1,则不对模板进行处理
		$sdef_fields = getresult("select * from I_field where columnid in (".getChanelidByColumnid($columnid).")");
		//echo "select * from I_field where columnid in (".getChanelidByColumnid($columnid).")";
		$fieldname = "";
		$fieldvalue = "";
		while($row = getresultarray($sdef_fields))
		{
			$fieldname = $row["fieldname"];
			$temparticle = getresult("select * from I_article where id=$id");
			if(!$temparticle)
				continue;
			$fieldvalue = getresultData($temparticle,0,$fieldname);
			//如果值为空，则替换为空串
			if($fieldvalue==NULL)
				$fieldvalue = "";
			$template = str_replace("【#".$fieldname."】",$fieldvalue,$template);
		}
	}

	return $template;
}
?>
