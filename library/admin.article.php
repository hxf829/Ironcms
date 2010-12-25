<?php
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
//print_r($functionarray);
$childcolumnString = "";//申明全局变量以供showarticle和getchildcolumnid_improveed使用以避免安全模式未开启情况下的错误
?>
<?php
/*showarticle显示后台文章列表
$columnid为栏目id
$page为所查看的页数
$pagesize为页的大小，可根据需要修改*/
function showarticle($columnid, $currentpage, $pagesize=10)
{
    global $childcolumnString,$functionarray;
	getchildcolumnid_improveed($columnid);
	//echo $childcolumnString."haoxuefeng";
	/*if($functionarray[$columnid]==="2"||getlogininfo("adminrole")==="0")
		$tempresult = getresult("select count(*) as countofarticle from I_article where columnid in (".$childcolumnString.")");
	else
		$tempresult = getresult("select count(*) as countofarticle from I_article where columnid in (".$childcolumnString.") and ifpass=0 and adminid=".getlogininfo("adminid"));
	$countofarticle = getresultData($tempresult, 0, "countofarticle");
	if($countofarticle<1)
	{
		echo "<tr class='list'>\n";
		echo "<td colspan='8' align='center'>暂无文章</td>\n";
		echo "</tr>";
		return;
	}*/
	//echo $countofarticle."|";
	//分页显示
    
	if($functionarray[$columnid]==="2"||getlogininfo("adminrole")==="0")
	{
			$query = "select * from I_article where columnid in (".$childcolumnString.") order by id desc limit ".($currentpage-1)*$pagesize.",$pagesize";
	}
	else
	{
			$query = "select * from I_article where columnid in (".$childcolumnString.") and ifpass=0 and adminid=".getlogininfo("adminid")." order by id desc limit ".($currentpage-1)*$pagesize.",$pagesize";

	}
		
	//echo $query;
	$result = getresult($query);
    if($currentpage>1 && getresultNumrows($result)<1)
	{
	    //echo $currentpage;
		echo "<script type=\"text/javascript\">window.location='admin_article.php?columnid=$columnid&currentpage=".($currentpage-1)."'</script>";
		return;
	}
	else if($currentpage<=1 && getresultNumrows($result)<1)
	{
	    echo "<tr class='list'>\n";
		echo "<td colspan='8' align='center'>".gettext_r("haveNot").gettext_r("article")."</td>\n";
		echo "</tr>";
		return;
	}
	while($row = getresultArray($result))
	{
		echo "<tr class='list'>\n";
		echo "<td align='center'><input type='checkbox' name='list' value='".$row["id"]."' /></td>";
		echo "<td>　".$row["id"]."</td>";
		echo "<td>　".getcolumnformation($row["id"], "columnname")."</td>";
		echo "<td>　".$row["title"]."</td>";
		echo "<td>　".$row["author"]."</td>";
		echo "<td>　".$row["hits"]."</td>";
		
		if($functionarray[$columnid]==="2"||getlogininfo("adminrole")==="0")
		{
			if($row["ifpass"]==1)
				echo "<td>　<a href='javascript:passarticle(".$row["id"].",0)'>".gettext_r("havePass")."</a></td>";
			else
				echo "<td>　<a href='javascript:passarticle(".$row["id"].",1)'>".gettext_r("notPass")."</a></td>";
		}
		else
		{
			if($row["ifpass"]==1)
				echo "<td>　".gettext_r("havePass")."</td>";
			else
				echo "<td>　".gettext_r("notPass")."</td>";
		}
		//操作权限
		echo "<td>";
		echo "　<a href=\"javascript:jump('admin_article.php','modify',".$row["id"].",'columnid',$columnid)\">".gettext_r("update")."</a> ";
		echo "| <a href=\"javascript:if(confirm('".gettext_r("ifDelete")."'))jump('admin_article.php','delete',".$row["id"].")\">".gettext_r("delete")."</a>";
		echo "</td>";
		echo "</tr>\n";
	}
}
/*getchildcolumnid得到子栏目字符串（例如1，2，3）
$columnid为栏目id
$childidstring为所要填充的字符串
第三个参数，为默认参数，为函数辅助参数，不要修改*/
//function getchildcolumnid($columnid, $childidstring, $index=0)
//{
//	if($index==0)
//		$childidstring = $columnid;
//	$query = "select childcolumn from I_column where id=$columnid";
//	$result = getresult($query);
//	$count = getresultNumrows($result);
//	if($count > 0)
//	{
//		$childColumnId = getresultData($result,0,"childcolumn");
//		//没有子栏目即返回
//		//echo $childColumnId."<br>";
//		if(($childColumnId == NULL)||($childColumnId == 0)||($childColumnId == ""))
//		{
//			return false;
//		}
//		$childId = explode("|",$childColumnId);
//		foreach($childId as $id)
//		{
//			$childidstring.=(",".$id);
//			//echo $childidstring;
//			getchildcolumnid($id , &$childidstring, $index+1);
//		}
//	}
//	else
//		return false;
//}
//测试得到子栏目id
/*$string = "";*/
/*include "../conn.php";*/
/*getchildcolumnid(2, &$string);
echo $string;*/

//下面的函数是getchildcolumnid的升级版，没有使用引用参数，而是使用全局变量
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
			return "";//修改过
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
/*
getchildcolumnid_improveed(2, $string);
echo $string;*/

/*showpage显示文章列表页面导航
$columnid为栏目id
$currentpage为当前页数
$pagesize为页的大小，可根据需要修改*/
function showpage($columnid, $currentpage, $pagesize=10)
{
	global $childcolumnString,$functionarray;
	getchildcolumnid_improveed($columnid, $childcolumnString);
	//echo $childcolumnString;
	if($functionarray[$columnid]==="2"||getlogininfo("adminrole")==="0")
		$tempresult = getresult("select count(*) as countofarticle from I_article where columnid in (".$childcolumnString.")");
	else
		$tempresult = getresult("select count(*) as countofarticle from I_article where columnid in (".$childcolumnString.") and ifpass=0 and adminid=".getlogininfo("adminid"));
	
	$countofarticle = getresultData($tempresult, 0, "countofarticle");
	if($countofarticle%$pagesize == 0)
		$allpage = $countofarticle/$pagesize;
	else
		$allpage = floor($countofarticle/$pagesize) + 1;
	//消除文章数为零时显示下一页链接的bug
	if($countofarticle==0)
		$allpage += 1;

	echo gettext_r("total")."<b> ".$allpage." </b>".gettext_r("page")."(".$pagesize." ".gettext_r("piece").gettext_r("article").gettext_r("per").gettext_r("page").")　";
	if($currentpage==1)
		echo gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
	else
		echo "<a href='admin_article.php?columnid=$columnid&currentpage=1'>".gettext_r("firstPage")."</a> | <a href='admin_article.php?columnid=$columnid&currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
	
	$temppage = 1;
	if(($currentpage-1)<5)
		while($temppage <= $currentpage)
		{
			if($currentpage==$temppage)
			{
				echo "<b>".$temppage."</b> ";
				$temppage++;
				continue;
			}
			echo "<a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
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
				echo "<a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> … ";
				$temppage++;
				continue;
			}
			if(($currentpage-$temppage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	if(($allpage-$currentpage)<5)
		while($temppage <= $allpage)
		{
			if($temppage==1)
			{
				echo "<a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			echo "<a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	else
		while($temppage <= $allpage)
		{
			if($temppage==$allpage)
			{
				echo " … <a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			if(($temppage-$currentpage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_article.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	
	if($currentpage==$allpage)
		echo "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
	else
		echo "| <a href='admin_article.php?columnid=$columnid&currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='admin_article.php?columnid=$columnid&currentpage=$allpage'>".gettext_r("lastPage")."</a>";
}
/*showcolumnlist显示子栏目列表
$columnid为栏目id
$currentpage为当前页数
第三个参数，为默认参数，为函数辅助参数，不要修改*/
function showcolumnlist($columnid , $columnofarticleid=-1, $classindex=0)
{
			$query = "select childcolumn from I_column where id=$columnid";
			$result = getresult($query);
			$count = getresultNumrows($result);
			if($classindex==0)
			{
				$tempresult = getresult("select * from I_column where id=$columnid");
				$columnname = getresultData($tempresult, 0, "columnname");
				//echo $columnname;
				if($columnid == $columnofarticleid)
					echo "<option selected=\"true\" value='".$columnid."'>\n";
				else
					echo "<option value='".$columnid."'>\n";
				echo "$columnname</option>";
			}
			if($count > 0)
			{
				$childColumnId = getresultData($result,0,"childcolumn");
				//没有子栏目即返回
				//echo $childColumnId."<br>";
				if(($childColumnId == NULL)||($childColumnId == 0)||($childColumnId == ""))
				{
					if($classindex==0)
					{
						//echo "<option value='-1'>暂无栏目</option>";
					}
					return false;
				}
				$childId = explode("|",$childColumnId);
				foreach($childId as $id)
				{
					$getchildcolumnQuery = "select columnname,childcount from I_column where id=$id";
					
					$childColumn = getresult($getchildcolumnQuery);
					
					$childColumnname = getresultData($childColumn,0,"columnname");
					$childCount = getresultData($childColumn,0,"childcount");
					if($id == $columnofarticleid)
						echo "<option selected=\"true\" value='".$id."'>\n";
					else
						echo "<option value='".$id."'>\n";
					echo space($classindex+1).$childColumnname."</option>\n";
					//如果为大栏目调整，则不递归显示子栏目
					if($columnid!=0)
						showcolumnlist($id , $columnofarticleid, $classindex+1);
				}
			}
			else
				return false;
}
?>