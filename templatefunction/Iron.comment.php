<?php
/*调用格式
*【commentlist】
*/
$articleid = $_GET["articleid"];
$siteconfig = getresult("select * from I_siteconfig");
$article = getresult("select * from I_article where id=$articleid");
if($article==null||getresultNumrows($article)<1)
	die("<script type='text/javascript'>window.location='error.html'</script>");
$comment = getresult("select * from I_comment where articleid=$articleid and ifpass=1");
global $id,$articleid,$username,$addtime,$commentcontent,$userip,$support,$against,$quoteid;
//得到评论总数和显示总数
function getCountOfcomment ($type=0)//默认0为全部评论数，1为通过审核的评论数
{
	global $articleid;
	if($type==0)
	    $query = "select count(*) as countofcomment from I_comment where articleid=$articleid";
	else
		$query = "select count(*) as countofcomment from I_comment where articleid=$articleid and ifpass=1";
	return getresultData(getresult($query), 0, "countofcomment");
}
//得到评论页题目
function getHtmltitle ()
{
    global $siteconfig, $article, $column;
    if(getresultNumrows($article)<1)
        return "error";
    return getresultData($article, 0, "title");
}
//得到网站名称
function getSitename ()
{
    global $siteconfig, $article, $column;
    return getresultData($siteconfig, 0, "sitename");
}
//取得版权信息
function getCopyright ()
{
    global $siteconfig, $article, $column;
    return getresultData($siteconfig, 0, "copyright");
}
//取得logo地址
function getLogo ()
{
    global $siteconfig, $article, $column;
    return getresultData($siteconfig, 0, "logo");
}
//得到评论框
function getCommentform()
{
    return "<form id=\"commentform\" name=\"commentform\" method=\"post\" action=\"postcomment.php\">
  <div clsss=\"commentcotent\"><textarea class=\"replytextarea\" name=\"commentcotent\"></textarea></div>
</form>";
}
//初始化一篇评论的信息
function initCommentData($row)
{
    global $id,$articleid,$username,$addtime,$commentcontent,$userip,$support,$against,$quoteid;
    $id = $row["id"];
    $articleid = $_GET["articleid"];
    $username = $row["username"];
    //echo $time."<br><br><br><br><br><br><br><br><br>";
    $addtime = $row["addtime"];
    $commentcontent = $row["commentcontent"];
    $userip = $row["userip"];
    $support = $row["support"];
    $against = $row["against"];
	$quoteid = $row["quoteid"];
}
//替换模板中的标签
function getvalue($name)
{
    global $id,$articleid,$username,$addtime,$commentcontent,$userip,$support,$against,$quoteid;
    if($name=="【#id】")
	    return $id;    
	elseif($name=="【#articleid】")
	    return $articleid;
    elseif($name=="【#username】")
	    return $username;
	elseif($name=="【#addtime】")
	    return $addtime;
	elseif($name=="【#commentcontent】")
	    return $commentcontent;
	elseif($name=="【#hits】")
	    return $hits;
	elseif($name=="【#userip】")
	    return $userip;
	elseif($name=="【#support】")
	    return $support;
    elseif($name=="【#against】")
	    return $against;
	elseif($name=="【#quote】")//回复的帖子
	{
		if($quoteid=="0")
			return "";
		else
			return "<!--<quote>".$quoteid."</quote>-->";
	}
	else
		return "bad data";
}
//得到页码导航
function getCommentPage()
{
    //echo "haoxuefeng";
    $articleid = $_GET["articleid"];
    if(!isset($articleid)||$articleid=="")
        return "";
    //页面导航字符串
    $Page = "";
    //从url得到参数
    $currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
    $pagesize = ($_GET["pagesize"]==NULL || $_GET["pagesize"]<=0)?20:$_GET["pagesize"];
    //echo $currentpage;
    //echo $pagesize;
    //echo $articleid;
    $tempresult = getresult("select count(*) as countofcomment from I_comment where articleid=$articleid and ifpass=1 ");
    $countofcomment = getresultData($tempresult, 0, "countofcomment");
    //echo "|".$countofarticle;
    if ($countofcomment % $pagesize == 0)
        $allpage = $countofcomment / $pagesize;
    else
        $allpage = floor($countofcomment / $pagesize) + 1;
        //消除文章数为零时显示下一页链接的bug
    if ($countofcomment == 0)
        $allpage += 1;
        //echo $countofarticle%$pagesize." ".$currentpage;
    $Page .= "<b> " . $allpage . " </b> Pages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($currentpage == 1)
        $Page .= "First | pre | ";
    else
        $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=1'>First</a> | <a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=".($currentpage-1)."'>Pre</a> | ";
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
            $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> ";
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
                $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> … ";
                $temppage ++;
                continue;
            }
            if (($currentpage - $temppage) > 3)
            {
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if (($allpage - $currentpage) < 5)
        while ($temppage <= $allpage)
        {
            if ($temppage == 1)
            {
                $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $allpage)
        {
            if ($temppage == $allpage)
            {
                $Page .= " … <a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            if (($temppage - $currentpage) > 3)
            {
                $temppage ++;
                continue;
            }
            $Page .= "<a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if ($currentpage == $allpage)
        $Page .= "| Next | Last";
    else
        $Page .= "| <a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=".($currentpage+1)."'>Next</a> | <a href='showcomment.php?articleid=$articleid&pagesize=$pagesize&currentpage=$allpage'>Last</a>";

    return $Page;
}
//转换自定义标签
//这个函数先把是把一页的评论调出来，但是此时楼的效果还没有出来，因为里面含有大量的<!--<quote>23</quote>-->再通过解析此内容将楼盖起来
function translateCommentlist ($template)
{
    //匹配自定义文章列表标签正则
	$html = $template;
    $flag = "/【#commentlist】/";
    if(preg_match_all($flag, $template, $matches, PREG_SET_ORDER))
		return str_replace($matches[0][0],getInitialCommentdiv(),$html);
    //替换所有articlelist标签
    /*$html = $template;
    //echo $template."<br>".$flag;
    //自定义参数评论每页显示条数
    $pagesize = ($_GET["pagesize"]==NULL || $_GET["pagesize"]<=0)?20:$_GET["pagesize"];
    $currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
    //得到需要循环的部分
    $str = $matches[0][1];
    //echo $str;
    //echo $str ;
    //得到子栏目id数组
    $articleid = $_GET["articleid"];
    $query = "select * from I_comment where articleid=$articleid and ifpass=1 limit ".($currentpage-1)*$pagesize.",$pagesize";
    //echo $query;
    $result = getresult($query);
    if (getresultNumrows($result) < 1) 
    {
        //没有评论
        return str_replace($matches[0][0], "No comments!", $html);
    }
    
    //匹配要显示的数据
    $tag_flag = "/【#[\s\S]*?】/";
    preg_match_all($tag_flag, $str, $data_tag,PREG_SET_ORDER);
    
    //将要输出的html代码;
    $temphtml = "";
    while ($row = getresultArray($result))
    {
        $str = $matches[0][1];
		$commentTemplate = $matches[0][1];//生成回帖楼的用户定义的一个帖子的模板
        //初始化数据
        initCommentData($row);

        foreach ($data_tag as $temp) 
        {
            //替换标签
            $str = str_replace($temp[0], getvalue($temp[0]), $str);
        }
        $temphtml .= $str;
    }
	
	//盖楼部分，替换$temphtml中的<!--<quote>23</quote>-->标签
	for(;;)
	{
		$quoteFlag = "/<!--<quote>(\d+?)<\/quote>-->/";
		if(preg_match_all($quoteFlag, $temphtml, $quoteMatches, PREG_SET_ORDER))
		{
			//如果字串中有<!--<quote>(\d*?)<\/quote>-->则替换之
			//echo "郝学峰".$quoteMatches[0][1].$quoteMatches[0][0]."郝学峰";
			//print_r($quoteMatches);
			$temphtml = str_replace($quoteMatches[0][0], getcommentdiv($quoteMatches[0][1], $commentTemplate), $temphtml);
			//print_r($quoteMatches);
			//echo "郝学峰";
		}
		else
		{
			break;
		}
	}
	//盖楼结束
	
    $html = str_replace($matches[0][0],$temphtml,$html);
    return $html;*/
}
//翻译评论模板普通标签
function translateCommentCommonlabel ($template)
{
	global $articleid;
    $template = str_replace("【#sitename】", getSitename(), $template);
	$template = str_replace("【#path】", getPath(), $template);
    $template = str_replace("【#htmltitle】", getHtmltitle(), $template);
    $template = str_replace("【#copyright】", getCopyright(), $template);
    $template = str_replace("【#logo】", getLogo(), $template);
    $template = str_replace("【#articletitle】", getHtmltitle(), $template); //评论页文章题目和此页面title一样
    $template = str_replace("【#commentform】", getCommentform(), $template);
    $template = str_replace("【#showpage】", getCommentPage(), $template);
	
	$template = str_replace("【#articleid】", $articleid, $template);
	$template = str_replace("【#commentshowcount】", getCountOfcomment(1), $template);
	$template = str_replace("【#commentrealcount】", getCountOfcomment(0), $template);
    return $template;
}
//得到最初要显示的pagesize个帖子
function getInitialCommentdiv()
{
	$pagesize = ($_GET["pagesize"]==NULL || $_GET["pagesize"]<=0)?20:$_GET["pagesize"];
    $currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];

    $articleid = $_GET["articleid"];
    $query = "select * from I_comment where articleid=$articleid and ifpass=1 order by id desc limit ".($currentpage-1)*$pagesize.",$pagesize";
	
	$result = getresult($query);
    if (getresultNumrows($result) < 1) 
    {
        //没有评论
        return "No comments!";
    }
	
	while ($row = getresultArray($result))
    {
        //初始化数据
        initCommentData($row);

		$str = "<div id='".getvalue("【#id】")."' class='comment'><div class='author'>".getvalue("【#username】")."</div><div class='postTime'>".getvalue("【#addtime】")."</div>
				".getvalue("【#quote】").
				"<div class='commentcontent'>".getvalue("【#commentcontent】")."</div>".
				"<ul class='operations'>
				<LI><A class='quote' href='javascript:quote(".getvalue("【#id】").")'>回复</A></LI>
				<LI class=support><A href='javascript:support(".getvalue("【#id】").")'>支持</A>[<SPAN>".getvalue("【#support】")."</SPAN>]</LI>
				<LI class=against><A href='javascript:against(".getvalue("【#id】").")'>反对</A>[<SPAN>".getvalue("【#against】")."</SPAN>]</LI>
				</ul>
				</div>
				<div class='segement'></div>";

        $temphtml .= $str;
    }
	
	//盖楼部分，替换$temphtml中的<!--<quote>23</quote>-->标签
	for(;;)
	{
		$quoteFlag = "/<!--<quote>(\d+?)<\/quote>-->/";
		if(preg_match_all($quoteFlag, $temphtml, $quoteMatches, PREG_SET_ORDER))
		{
			$temphtml = str_replace($quoteMatches[0][0], getcommentdiv($quoteMatches[0][1], $commentTemplate), $temphtml);
		}
		else
		{
			break;
		}
	}
	//盖楼结束
	
    $html = $temphtml;
    return $html;
}
//得到评论楼的基本div
function getcommentdiv($quoteid, $commentTemplate)
{
	//如果quoteid不为０将【floor】替换为<!--<quote>23</quote>-->
	//否则将【floor】替换为空
	//其它标签按模板输出
	
	//$str = $commentTemplate;
	
	//$tag_flag = "/【#[\s\S]*?】/";
    //preg_match_all($tag_flag, $str, $data_tag,PREG_SET_ORDER);
	//生成一个帖子的模板

    //初始化数据
	
	$row = getresultArray(getresult("select * from I_comment where id=$quoteid"));
    initCommentData($row);
      
    /*foreach ($data_tag as $temp) 
    {
        //替换标签
        $str = str_replace($temp[0], getvalue($temp[0]), $str);
    }*/
	//echo "郝学峰".$row["commentcontent"]."郝学峰"."select * from I_comment where id=$quoteid";
	if($row == null||$row == false)	
		return "";
	
	if($row["quoteid"]>0)
		return "<div class=\"quotecomment\"><!--<quote>".$row["quoteid"]."</quote>--><div class='author'>".getvalue("【#username】")."</div><div class='postTime'>".getvalue("【#addtime】")."</div><div class='quotecontent'>"
	.getvalue("【#commentcontent】").
	"</div></div>";
	else
		return "<div class=\"quotecomment\"><div class='author'>".getvalue("【#username】")."</div><div class='postTime'>".getvalue("【#addtime】")."</div><div class='quotecontent'>"
	.getvalue("【#commentcontent】").
	"</div></div>";
}
?>