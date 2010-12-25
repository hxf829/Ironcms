<?php
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
$childcolumnString = "";//申明全局变量以供showarticle和getchildcolumnid_improveed使用以避免安全模式未开启情况下的错误
?>
<?php
function showchildcolumncomment ($columnid)
{
    $result = getresult("select * from I_column where id=$columnid");
    if(getresultData($result, 0, "childcount")>=1)
    {
        $childcolumn = getresultData($result, 0, "childcolumn");
        //echo $childcolumn;
        $childid = explode("|", $childcolumn);
        foreach ($childid as $id) 
        {
            echo "<a href='admin_comment.php?columnid=$id'>".getcolumnformationBycolumnid($id,"columnnamezh")."</a>　";
        }
    }
    else 
        echo gettext_r("haveNot").gettext_r("child").gettext_r("column");
}
function showcomment($columnid, $currentpage, $pagesize=10)
{
    global $childcolumnString;
    getchildcolumnid_improveed($columnid);
	$result = getresult("select * from I_comment where articleid in (".getarticleidlist($columnid).") order by id desc limit ".($currentpage-1)*$pagesize.","."$pagesize");
	//echo "select * from I_comment where articleid in (".getarticleidlist($columnid).") limit ".($currentpage-1)*$pagesize.","."$pagesize";
    if($currentpage>1 && getresultNumrows($result)<1)
	{
		echo "<script type=\"text/javascript\">window.location='admin_comment.php?columnid=$columnid&currentpage=".($currentpage-1)."'</script>";
		return;
	}
	if(getresultnumrows($result)<1)
	{
	    echo "<tr>";
		echo "<td colspan='6' height='25' align='center'>".gettext_r("haveNot").gettext_r("comment")."</td>";
		echo "<tr>";
		return;
	}
	while($row = getresultarray($result))
	{
		echo "<tr class='list'>";
		echo "<td align='center'><input type='checkbox'  name='list'  value='".$row["id"]."'></td>\n";
		echo "<td align='center'>".$row["id"]."</td>\n";
		echo "<td align='center'>";
		echo getresultData(getresult("select title from I_article where id=".$row["articleid"]),0,"title");
		echo "</td>\n";
		echo "<td align='center'>".$row["commentcontent"]."</td>\n";
		echo "<td align='center'>".$row["username"]."</td>\n";
		echo "<td align='center'>";
		if($row["ifpass"]==="0")
			echo gettext_r("havePass");
		else 
			echo gettext_r("notPass");
		echo "</td>\n";
		echo "<td align='center' width='100'><a href=\"javascript:if(confirm('".gettext_r("ifDelete")."'))jump('admin_comment.php','delete',".$row["id"].")\">".gettext_r("delete")."</a></td>\n";
		echo "</tr>";
	}
}
//评论翻页显示(后台)
function showcommentpage($columnid, $currentpage, $pagesize=10)
{
	$tempresult = getresult("select count(*) as countofcomment from I_comment where articleid in (".getarticleidlist($columnid).")");

	$countofcomment = getresultData($tempresult, 0, "countofcomment");
	if($countofcomment%$pagesize == 0)
		$allpage = $countofcomment/$pagesize;
	else
		$allpage = floor($countofcomment/$pagesize) + 1;
	//消除文章数为零时显示下一页链接的bug
	if($countofcomment==0)
		$allpage += 1;
	
	//echo $countofcomment%$pagesize." ".$currentpage;
	echo gettext_r("total")."<b> ".$allpage." </b>".gettext_r("page")."(".$pagesize." ".gettext_r("piece").gettext_r("comment").gettext_r("per").gettext_r("page").")　";
	if($currentpage==1)
		echo gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
	else
		echo "<a href='admin_comment.php?columnid=$columnid&currentpage=1'>".gettext_r("firstPage")."</a> | <a href='admin_comment.php?columnid=$columnid&currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
	
	$temppage = 1;
	/*while($temppage <= $allpage)
	{
		if($currentpage==$temppage)
			echo "<b>".$temppage."</b> ";
		else
			echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
		if(($currentpage-1)<5)	
			echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> "
		if(($currentpage-1)>=5)
		$temppage++;
	}*/
	if(($currentpage-1)<5)
		while($temppage <= $currentpage)
		{
			if($currentpage==$temppage)
			{
				echo "<b>".$temppage."</b> ";
				$temppage++;
				continue;
			}
			echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	else
		while($temppage <= $currentpage)
		{
			if($currentpage==$temppage)
			{
				echo "<b>".$temppage."</b> ";
				$temppage++;
				continue;
			}
			if($temppage==1)
			{
				echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> … ";
				$temppage++;
				continue;
			}
			if(($currentpage-$temppage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	if(($allpage-$currentpage)<5)
		while($temppage <= $allpage)
		{
			if($temppage==1)
			{
				echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	else
		while($temppage <= $allpage)
		{
			if($temppage==$allpage)
			{
				echo " … <a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			if(($temppage-$currentpage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_comment.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	
	if($currentpage==$allpage)
		echo "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
	else
		echo "| <a href='admin_comment.php?columnid=$columnid&currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='admin_comment.php?columnid=$columnid&currentpage=$allpage'>".gettext_r("lastPage")."</a>";
}
//得到子栏目id字串
function getchildcolumnid_improveed($columnid, $index=0)
{
	global $childcolumnString;
	if($index==0)
		$childcolumnString = $columnid;
	$query = "select childcolumn from I_column where id=$columnid";
	//echo $query."<br>";
	$result = getresult($query);
	$count = getresultNumrows($result);
	//echo $count."<br>";
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
			$childcolumnString.=(",".$id);
			getchildcolumnid_improveed($id, $index+1);
		}
	}
	else
		return false;
}
//按权限得到可管理的文章列表id,这为得到可管理的评论id服务
function getarticleidlist($columnid)
{
	global $childcolumnString;
	getchildcolumnid_improveed($columnid);
    if($functionarray[$columnid]==="2"||getlogininfo("adminrole")==="0")
	    $query = "select id from I_article where columnid in ($childcolumnString)";
	else 
	    $query = "select id from I_article where columnid in ($childcolumnString) and adminid=".getlogininfo("adminid");
	$result = getresult($query);
	
	if(getresultNumrows($result)<1)
	    return "-1";
	else
	{
	    $articleidlist = "";
	    while($row = getresultArray($result))
	    {
	        if($articleidlist == "")
	            $articleidlist = $row["id"];
	        $articleidlist .= (",".$row["id"]);
	    }
	    return $articleidlist;
	}
}
?>