<?php
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
?>

<?php
/*showtemplatelist显示后台模板列表*/
function showmylabel($currentpage, $pagesize=10)
{
	$tempresult = getresult("select count(*) as countoflabel from I_mylabel");
	
	$countoflabel = getresultData($tempresult, 0, "countoflabel");
	if($countoflabel<1)
	{
		echo "<tr class='list'>\n";
		echo "<td colspan='3' align='center'>".gettext_r("haveNot").gettext_r("selfDefineTip")."</td>\n";
		echo "</tr>";
		return;
	}
	
	$query = "select * from I_mylabel order by id desc limit ".($currentpage-1)*$pagesize.",$pagesize";
	$result = getresult($query);
	while($row = getresultArray($result))
	{
		echo "<tr class='list'>\n";
		echo "<td>　".$row["id"]."</td>";
		echo "<td>　".$row["labelname"]."</td>";
		echo "<td align='center'>";
		echo "<a href=\"javascript:jump('admin_mylabel.php','modify',".$row["id"].")\">".gettext_r("update")."</a> | <a href=\"javascript:if(confirm('".gettext_r("ifDelete")."'))jump('admin_mylabel.php','delete',".$row["id"].")\">".gettext_r("delete")."</a>";
		echo "</td>";
		echo "</tr>\n";
	}
}

function showpage($currentpage, $pagesize=10)
{
	$tempresult = getresult("select count(*) as countoflabel from I_mylabel");

	$countoflabel = getresultData($tempresult, 0, "countoflabel");
	if($countoflabel%$pagesize == 0)
		$allpage = $countoflabel/$pagesize;
	else
		$allpage = floor($countoflabel/$pagesize) + 1;
	//消除文章数为零时显示下一页链接的bug
	if($countoflabel==0)
		$allpage += 1;
	
	echo gettext_r("total")."<b> ".$allpage." </b>".gettext_r("page")."(".$pagesize." ".gettext_r("piece").gettext_r("selfDefineTip").gettext_r("per").gettext_r("page").")　";
	if($currentpage==1)
		echo gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
	else
		echo "<a href='admin_article.php?columnid=$columnid&currentpage=1'>".gettext_r("firstPage")."</a> | <a href='admin_article.php?columnid=$columnid&currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
	
	$temppage = 1;
	/*while($temppage <= $allpage)
	{
		if($currentpage==$temppage)
			echo "<b>".$temppage."</b> ";
		else
			echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
		if(($currentpage-1)<5)	
			echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> "
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
			echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
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
				echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> … ";
				$temppage++;
				continue;
			}
			if(($currentpage-$temppage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	if(($allpage-$currentpage)<5)
		while($temppage <= $allpage)
		{
			if($temppage==1)
			{
				echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	else
		while($temppage <= $allpage)
		{
			if($temppage==$allpage)
			{
				echo " … <a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			if(($temppage-$currentpage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_mylabel.php?currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	
	if($currentpage==$allpage)
		echo "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
	else
		echo "| <a href='admin_article.php?columnid=$columnid&currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='admin_article.php?columnid=$columnid&currentpage=$allpage'>".gettext_r("lastPage")."</a>";
}
?>