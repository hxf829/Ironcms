<?php
/*调用格式
*【searchlist(articlenum,titlelen,timetype,sorttype)】
*<h2>【#title】</h2>
*<b>【#time】</b>
*【/searchlist】
* 调用示例
*【searchlist(1,6,2,0)】
*<tr>
*	<td>【#title】</td>
*	<td>【#time】</td>
*	<td>【#title】</td>
*	<td>【#time】</td>
*	<td>【#title】</td>
*	<td>【#time】</td>
*	<td>【#title】</td>
*	<td>【#time】</td>
*【/searchlist】
*/
function getsearchform()
{
	$searchFormStr = "";
	$searchFormStr .= "<form name='form1' action='' method='get'>";
	$searchFormStr .=  "<input type='hidden' name='columnid' value='".$_GET["columnid"]."'/>";
	$searchFormStr .=  "产品名称:<input type='text' name='title' value='".$_GET["title"]."'><br>";
	//各种 产品属性
	if($_GET["columnid"]!=NULL&&$_GET["columnid"]>0)
	{
		$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($_GET["columnid"]));
		while($row = getresultarray($sdef_fields))
		{
			if($row["datatype"]=="double")
			{
				$searchFormStr .=  $row["info"].":<select name='".$row["fieldname"]."ctype'>";
				switch($_GET[$row["fieldname"]."ctype"])
				{
					case '<':
						$searchFormStr .=  "<option selected='selected' value='<'>&lt;</option><option value='='>=</option><option value='>'>&gt;</option>";
					case '>':
						$searchFormStr .=  "<option value='<'>&lt;</option><option value='='>=</option><option value='>' selected='selected'>&gt;</option>";
					default:
						$searchFormStr .=  "<option value='<'>&lt;</option><option selected='selected' value='='>=</option><option value='>'>&gt;</option>";
				}
				$searchFormStr .=  "</select>";
				$searchFormStr .=  "<input type='text' value='".$_GET[$row["fieldname"]]."' name='".$row["fieldname"]."'><br>";
			}
			else
			{
				$searchFormStr .=  $row["info"].":<input type='text' value='".$_GET[$row["fieldname"]]."' name='".$row["fieldname"]."'><br>";
			}
		}
	}
$searchFormStr .= "<input type='submit' value='".gettext_r("search")."'/>";
$searchFormStr .= "</form>";
return $searchFormStr;
}
//得到页码导航
function getsearchPage($pagesize)
{
    $columnid = $_GET["columnid"];
    //页面导航字符串
    $Page = "";
    //从url得到参数
    $currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];

	$searchSql = "select count(*) as countofarticle from I_article where ifpass=1";
		if($_GET["title"]!=NULL&&$_GET["title"]!="")
		{
			$searchSql .= " and  title like '%".$_GET["title"]."%'";
		}
		if($_GET["columnid"]!=NULL&&$_GET["columnid"]>0)
		{
			$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($_GET["columnid"]));
			while($row = getresultarray($sdef_fields))
			{
				if($_GET[$row["fieldname"]]==NULL||$_GET[$row["fieldname"]]=="")
					continue;
				if($row["datatype"]=="double")
				{
					$searchSql .= " and ".$row["fieldname"]." ".$_GET[$row["fieldname"]."ctype"].$_GET[$row["fieldname"]]; 
					//echo $_GET[$row["fieldname"]."ctype"]."测试";
				}
				else
				{
					$searchSql .= " and ".$row["fieldname"]." like '".$_GET[$row["fieldname"]]."'"; 
				}
			}
			//在所有子栏目中搜索
			$childcolumnStr = "";
			getchildcolumnid($_GET["columnid"], $childcolumnStr);
			$searchSql .= " and columnid in (".$childcolumnStr.")";
			//echo "Iron".$searchSql;
		}
		
	$searchSql .= (" ".$sortstr);
	//echo $searchSql;
    $tempresult = getresult($searchSql);
	
    $countofarticle = getresultData($tempresult, 0, "countofarticle");
    //echo "|".$countofarticle;
    if ($countofarticle % $pagesize == 0)
        $allpage = $countofarticle / $pagesize;
    else
        $allpage = floor($countofarticle / $pagesize) + 1;
        //消除文章数为零时显示下一页链接的bug
    if ($countofarticle == 0)
        $allpage += 1;
        //echo $countofarticle%$pagesize." ".$currentpage;
	
	//链接前缀
	$searchresultUrl = $_SERVER['PHP_SELF']."?";
	foreach   ($_GET as $key=>$value)
	{
		if($key!="currentpage")
			$searchresultUrl .= ($key."=".$value."&");
	}
	
    $Page .= gettext_r("total")." <b> " . $allpage . " </b> ".gettext_r("page")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($currentpage == 1)
        $Page .= gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
    else
        $Page .= "<a href='".$searchresultUrl."currentpage=1'>".gettext_r("firstPage")."</a> | <a href='".$searchresultUrl."currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
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
            $Page .= "<a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> ";
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
                $Page .= "<a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> … ";
                $temppage ++;
                continue;
            }
            if (($currentpage - $temppage) > 3)
            {
                $temppage ++;
                continue;
            }
            $Page .= "<a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if (($allpage - $currentpage) < 5)
        while ($temppage <= $allpage)
        {
            if ($temppage == 1)
            {
                $Page .= "<a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            $Page .= "<a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $allpage)
        {
            if ($temppage == $allpage)
            {
                $Page .= " … <a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            if (($temppage - $currentpage) > 3)
            {
                $temppage ++;
                continue;
            }
            $Page .= "<a href='".$searchresultUrl."currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if ($currentpage == $allpage)
        $Page .= "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
    else
        $Page .= "| <a href='".$searchresultUrl."currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='".$searchresultUrl."currentpage=$allpage'>".gettext_r("lastPage")."</a>";
		//echo $Page."好".$pagesize;
    return $Page;
}
//翻译模板中的【articlelist(columnid,articlenum,titlelen,ifpage)】自定义标签
function translateSearchlist($template)
{
	global $pagesize;//如果指定页大小，则用用户参数填充$pagesize
	
    //匹配自定义文章列表标签正则
    $flag = "/【searchlist(\(\d*,\d*,\d*,\d*\))】([\s\S]*?)【\/searchlist】/";
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
		$articlenum = $parameter[0];
    	$titlelen = $parameter[1];
    	$timetype = $parameter[2];
		$sorttype = $parameter[3];
		
		//定义排序方式的字串		
		if($sorttype=="0")//id降序
			$sortstr = "order by id desc";
		else
			$sortstr = "order by id asc";
		
    	//得到url参数
    	$pagesize = $articlenum;//($_GET["pagesize"]==NULL || $_GET["pagesize"]<=0)?10:$_GET["pagesize"];
    	$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
    	//根据参数从数据库取得数据
		$searchSql = "select *,left(title,$titlelen) as title from I_article where ifpass=1";
		if($_GET["title"]!=NULL&&$_GET["title"]!="")
		{
			$searchSql .= " and title like '%".$_GET["title"]."%'";
		}
		if($_GET["columnid"]!=NULL&&$_GET["columnid"]>0)
		{
			$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($_GET["columnid"]));
			while($row = getresultarray($sdef_fields))
			{
				if($_GET[$row["fieldname"]]==NULL||$_GET[$row["fieldname"]]=="")
					continue;
				if($row["datatype"]=="double")
				{
					$searchSql .= " and ".$row["fieldname"]." ".$_GET[$row["fieldname"]."ctype"].$_GET[$row["fieldname"]]; 
					//echo $_GET[$row["fieldname"]."ctype"]."测试";
				}
				else
				{
					$searchSql .= " and ".$row["fieldname"]." like '".$_GET[$row["fieldname"]]."'"; 
				}
			}
			//在所有子栏目中搜索
			$childcolumnStr = "";
			getchildcolumnid($_GET["columnid"], $childcolumnStr);
			$searchSql .= " and columnid in (".$childcolumnStr.")";
			//echo "Iron".$searchSql;
		}
		
		$searchSql .= (" ".$sortstr." limit ".($currentpage-1)*$pagesize.",$pagesize");
		
    	//echo $searchSql;
    	$result = getresult($searchSql);
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
    	//echo $matche[0]."<br>";//.$temphtml;
    	if(trim($temphtml)=="")
    	    $html = str_replace($matche[0],gettext_r("haveNot").gettext_r("search").gettext_r("result"),$html);
        else 
    	    $html = str_replace($matche[0],$temphtml,$html);
	}
	//显示搜索表单
	$html = str_replace("【#searchform】",getsearchform(),$html); 
	//显示分页
	$html = str_replace("【#showpage】",getsearchPage($pagesize),$html); 
	return $html;
}
?>