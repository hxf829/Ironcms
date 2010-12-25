<?php
//得到栏目id为$articleid的$attribute属性值
function getcolumnformation($articleid, $attribute)
{
	$result = getresult("select * from I_article where id=".$articleid);
	$columnid = getresultData($result, 0, "columnid");
	$result = getresult("select * from I_column where id=".$columnid);
	return getresultData($result, 0, $attribute);
}
/*showarticle显示后台文章列表
$columnid为栏目id
$page为所查看的页数
$pagesize为页的大小，可根据需要修改*/
function showarticlelist ($columnid, $page, $pagesize = 10)
{
    echo "<table width='670' cellpadding='0' cellspacing='0' border='0'>";
    $tempresult = getresult("select count(*) as countofarticle from I_article where columnid=$columnid and ifpass=1");
    $countofarticle = getresultData($tempresult, 0, "countofarticle");
    if ($countofarticle < 1)
    {
        echo "<tr class='list'>\n";
        echo "<td align='center'>No article</td>\n";
        echo "</tr>";
        echo "</table>";
        return;
    }
    //echo $countofarticle."|";
    //分页显示
    $query = "select * from I_article where columnid=$columnid and ifpass=1  order by id desc  limit ".($page-1)*$pagesize.",$pagesize";
    //echo $query;
    $result = getresult($query);
    if (getresultNumrows($result) < 1)
    {
        return;
    }
     echo "<tr class='articlesegline'>\n";
     echo "<td colspan='3'></td>";
     echo "</tr>";
    while ($row = getresultArray($result))
    {
        echo "<tr class='list'>\n";
        echo "<td><a href='#' onclick=\"goto('article.php?id=".$row["id"]."')\">" . $row["title"] . "</a></td>";
        echo "<td width='60'>" . $row["author"] . "</td>";
        echo "<td width='150'>" . $row["addtime"] . "</td>";
        echo "</tr>";
        echo "<tr class='articlesegline'>\n";
        echo "<td colspan='3'></td>";
        echo "</tr>";
    }
    echo "</table>";
}
/*showpage显示文章列表页面导航
$columnid为栏目id
$currentpage为当前页数
$pagesize为页的大小，可根据需要修改*/
function showpage ($columnid, $currentpage, $pagesize = 10)
{
    $tempresult = getresult("select count(*) as countofarticle from I_article where columnid=$columnid");
    $countofarticle = getresultData($tempresult, 0, "countofarticle");
    if ($countofarticle % $pagesize == 0)
        $allpage = $countofarticle / $pagesize;
    else
        $allpage = floor($countofarticle / $pagesize) + 1;
        //消除文章数为零时显示下一页链接的bug
    if ($countofarticle == 0)
        $allpage += 1;
        //echo $countofarticle%$pagesize." ".$currentpage;
    echo "<b> " . $allpage . " </b> Pages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($currentpage == 1)
        echo "First | pre | ";
    else
        echo "<a href='#' onclick='showarticlelist($columnid,1)'>First</a> | <a href='#' onclick='showarticlelist($columnid,".($currentpage+1).")'>Pre</a> | ";
    $temppage = 1;

    if (($currentpage - 1) < 5)
        while ($temppage <= $currentpage)
        {
            if ($currentpage == $temppage)
            {
                echo "<b>" . $temppage . "</b> ";
                $temppage ++;
                continue;
            }
            echo "<a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $currentpage)
        {
            if ($currentpage == $temppage)
            {
                echo "<b>" . $temppage . "</b> ";
                $temppage ++;
                continue;
            }
            if ($temppage == 1)
            {
                echo "<a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> … ";
                $temppage ++;
                continue;
            }
            if (($currentpage - $temppage) > 3)
            {
                $temppage ++;
                continue;
            }
            echo "<a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if (($allpage - $currentpage) < 5)
        while ($temppage <= $allpage)
        {
            if ($temppage == 1)
            {
                echo "<a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            echo "<a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $allpage)
        {
            if ($temppage == $allpage)
            {
                echo " … <a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            if (($temppage - $currentpage) > 3)
            {
                $temppage ++;
                continue;
            }
            echo "<a href='#' onclick='showarticlelist($columnid,$temppage)'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if ($currentpage == $allpage)
        echo "| Next | Last";
    else
        echo "| <a href='#' onclick='showarticlelist($columnid,".($currentpage+1).")'>Next</a> | <a href='#' onclick='showarticlelist($columnid,$allpage)'>Last</a>";
}
/*showcolumnlist显示子栏目列表
$columnid为栏目id
$currentpage为当前页数
第三个参数，为默认参数，为函数辅助参数，不要修改*/
function showchildcolumnlist ($columnid, $classindex = 0)
{
    
    $query = "select childcolumn,columnnameen from I_column where id=$columnid";
    $result = getresult($query);
    
    if(getresultNumrows($result)<1)
    {
        echo "<div style='font-size:13px;color:red;'>There was not such column or this column had been disabled!</div>";
        echo "<input type='button' onclick='history.back(-1)' value='Go Back!'/><input type='button' onclick=\"parent.open('','_parent','');parent.close();\" value='Close Window!'/>";    
        return;
    }
    
    $columnnameen = getresultData($result,0,"columnnameen");
    $childColumnId = getresultData($result,0,"childcolumn");
    if (($childColumnId == NULL) || ($childColumnId == 0) || ($childColumnId == ""))
    {
        echo "<script type='text/javascript'>parent.setTandL('$columnnameen','$columnnameen');showarticlelist($columnid,1);</script>";
        return false;
    }
    $childId = explode("|", $childColumnId);
    echo "<script type='text/javascript'>parent.setTandL('$columnnameen','$columnnameen');</script>";
    echo "<ul>";
    foreach ($childId as $id)
    {
        $getchildcolumnQuery = "select columnnameen,childcount from I_column where id=$id";
        $childColumn = getresult($getchildcolumnQuery);
        $childColumnname = getresultData($childColumn, 0, "columnnameen");
        echo "<li><a href='#tab$id'><span>$childColumnname</span></a></li>";
    }
    echo "</ul>";
    
    foreach ($childId as $id)
    {
        echo "<div id='tab$id'>";
        echo "<script type='text/javascript'>showarticlelist($id,1);</script>";
        echo "</div>";
    }
}
//显示文章
function showarticle($id)
{
    $query = "select * from I_article where id=$id and ifpass=1";
    $result = getresult($query);
    
    if(getresultNumrows($result)<1)
    {
        echo("<div style='font-size:13px;color:red;'>There was not such article or this article had been deleted!</div>");
        echo "<input type='button' onclick='history.back(-1)' value='Go Back!'/><input type='button' onclick=\"parent.open('','_parent','');parent.close();\" value='Close Window!'/>";
        return;
    }
        
    $title = getresultData($result,0,"title");
        
    echo "<div id='articletitle'>".$title."</div>";
    
    echo "<div id='articleinfo'>";
    echo "<span id='author'>Author:".getresultData($result,0,"author")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
    echo "<span id='from'>From:".getresultData($result,0,"source")."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";
    echo "<span id='views'>Views:".getresultData($result,0,"hits")."</span>";
    echo "</div>";
    
    echo "<div id='contents'>".getresultData($result,0,"contents")."</div>";
    
    //$columnnameen = getcolumnformation($id,"columnnameen");
    echo "<script type='text/javascript'>parent.setTandL('$title','$title');</script>";
}
//显示首字母搜索结果
function showletersearch($firstletter,$currentpage,$pagesize=10)
{
    echo "<table width='100%' cellpadding='0' cellspacing='0' border='0' style='font-size:12px;'>";
    $tempresult = getresult("select count(*) as countofarticle from I_article where left(title,1)='".$firstletter."' and ifpass=1");
    //echo $tempresult;
    $countofarticle = getresultData($tempresult, 0, "countofarticle");
    if ($countofarticle < 1)
    {
        echo "<tr class='list'>\n";
        echo "<td align='center'>No article</td>\n";
        echo "</tr>";
        echo "</table>";
        return;
    }
    //echo $countofarticle."|";

    //分页显示
    $query = "select * from I_article where left(title,1)='".$firstletter."' and ifpass=1  order by id desc  limit ".($currentpage-1)*$pagesize.",$pagesize";
    //echo $query;
    $result = getresult($query);
    if (getresultNumrows($result) < 1)
    {
        return;
    }
     echo "<tr class='articlesegline'>\n";
     echo "<td colspan='3'></td>";
     echo "</tr>";
    while ($row = getresultArray($result))
    {
        echo "<tr class='list'>\n";
        echo "<td><a href=\"javascript:parent.location='showarticle.php?articleid=".$row["id"]."'\";')\">" . $row["title"] . "</a></td>";
        echo "<td width='60'>" . $row["author"] . "</td>";
        echo "<td width='150' align='right'>" . $row["addtime"] . "</td>";
        echo "</tr>";
        echo "<tr class='articlesegline'>\n";
        echo "<td colspan='3'></td>";
        echo "</tr>";
    }
    echo "</table>";
    //分页
    echo "<div class='showpage'>";
    if ($countofarticle % $pagesize == 0)
        $allpage = $countofarticle / $pagesize;
    else
        $allpage = floor($countofarticle / $pagesize) + 1;
        //消除文章数为零时显示下一页链接的bug
    if ($countofarticle == 0)
        $allpage += 1;
        //echo $countofarticle%$pagesize." ".$currentpage;
    echo "<b> " . $allpage . " </b> Pages&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($currentpage == 1)
        echo "First | pre | ";
    else
        echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=1'>First</a> | <a href='articlelist.php?firstletter=$firstletter&currentpage=".($currentpage-1)."'>Pre</a> | ";
    $temppage = 1;

    if (($currentpage - 1) < 5)
        while ($temppage <= $currentpage)
        {
            if ($currentpage == $temppage)
            {
                echo "<b>" . $temppage . "</b> ";
                $temppage ++;
                continue;
            }
            echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $currentpage)
        {
            if ($currentpage == $temppage)
            {
                echo "<b>" . $temppage . "</b> ";
                $temppage ++;
                continue;
            }
            if ($temppage == 1)
            {
                echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage'>" . $temppage . "</a> … ";
                $temppage ++;
                continue;
            }
            if (($currentpage - $temppage) > 3)
            {
                $temppage ++;
                continue;
            }
            echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    if (($allpage - $currentpage) < 5)
        while ($temppage <= $allpage)
        {
            if ($temppage == 1)
            {
                echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage'>" . $temppage . "</a> ";
            $temppage ++;
        }
    else
        while ($temppage <= $allpage)
        {
            if ($temppage == $allpage)
            {
                echo " … <a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage'>" . $temppage . "</a> ";
                $temppage ++;
                continue;
            }
            if (($temppage - $currentpage) > 3)
            {
                $temppage ++;
                continue;
            }
            echo "<a href='articlelist.php?firstletter=$firstletter&currentpage=$temppage '>" . $temppage . "</a> ";
            $temppage ++;
        }
    if ($currentpage == $allpage)
        echo "| Next | Last";
    else
        echo "| <a href='articlelist.php?firstletter=$firstletter&currentpage=".($currentpage+1)."'>Next</a> | <a href='articlelist.php?firstletter=$firstletter&currentpage=$allpage'>Last</a>";
        
    echo "</div>";
}
//得到客户端IP
function GetUserIP(){
   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
           $ip = getenv("HTTP_CLIENT_IP");
       else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
           $ip = getenv("HTTP_X_FORWARDED_FOR");
       else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
           $ip = getenv("REMOTE_ADDR");
       else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
           $ip = $_SERVER['REMOTE_ADDR'];
       else
           $ip = "unknown";
   return($ip);
}
//得到登录用户的信息
function getUserInfo($name)
{
    $return = $_COOKIE[$name]!=NULL?$_COOKIE[$name]:$_SESSION[$name];
	//echo $_SESSION[$attribute].$_COOKIE[$attribute];
	if($return != NULL&&$return != "")
		return $return;
	else
		return "notdefined";
}
?>