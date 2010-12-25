<?php
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
?>

<?php
/*showuserlist显示后台用户名列表
$page为所查看的页数
$pagesize为页的大小，可根据需要修改*/
function showuserlist($currentpage, $pagesize=10)
{
	$tempresult = getresult("select count(*) as countofuser from I_user");
	$countofuser = getresultData($tempresult, 0, "countofuser");
	if($countofuser<1)
	{
		echo "<tr class='list'>\n";
		echo "<td colspan='8' align='center'>".gettext_r("haveNot").gettext_r("user")."</td>\n";
		echo "</tr>";
		return;
	}
	$query = "select * from I_user order by id desc limit ".($currentpage-1)*$pagesize.","."$pagesize";
			
	$result = getresult($query);
	while($row = getresultArray($result))
	{
		echo "<tr class='list'>\n";
		echo "<td>　".$row["id"]."</td>";
		echo "<td>　".$row["username"]."</td>";
		echo "<td>　".$row["logintimes"]."</td>";
		if($row["iflock"]==0)
			echo "<td>　<a href=\"javascript:if(confirm('".gettext_r("ifLockUser")."'))jump('admin_user.php','lock',".$row["id"].",'iflock',1)\">".gettext_r("unLock")."</a></td>";
		else
			echo "<td>　<a href=\"javascript:if(confirm('".gettext_r("ifUnLockUser")."'))jump('admin_user.php','lock',".$row["id"].",'iflock',0)\">".gettext_r("lock")."</a></td>";
	
		//操作权限
		echo "<td align='center'>";
		echo "　<a href=\"javascript:jump('admin_user.php','details',".$row["id"].")\">".gettext_r("see").gettext_r("details")."</a> ";
		echo "| <a href=\"javascript:if(confirm('".gettext_r("ifDelete")."'))jump('admin_user.php','delete',".$row["id"].")\">".gettext_r("delete")."</a>";
		echo "</td>";
		echo "</tr>\n";
	}
}
/*showpage显示文章列表页面导航
$columnid为栏目id
$currentpage为当前页数
$pagesize为页的大小，可根据需要修改*/
function showpage($currentpage, $pagesize=10)
{
	$tempresult = getresult("select count(*) as countofuser from I_user");

	$countofuser = getresultData($tempresult, 0, "countofuser");
	if($countofuser%$pagesize == 0)
		$allpage = $countofuser/$pagesize;
	else
		$allpage = floor($countofuser/$pagesize) + 1;
	//消除文章数为零时显示下一页链接的bug
	if($countofuser==0)
		$allpage += 1;
	
	echo gettext_r("total")."<b> ".$allpage." </b>".gettext_r("page")."(".$pagesize." ".gettext_r("piece").gettext_r("user").gettext_r("per").gettext_r("page").")　";
	if($currentpage==1)
		echo gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
	else
		echo "<a href='admin_user.php?columnid=$columnid&currentpage=1'>".gettext_r("firstPage")."</a> | <a href='admin_user.php?columnid=$columnid&currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
	
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
			echo "<a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
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
				echo "<a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> … ";
				$temppage++;
				continue;
			}
			if(($currentpage-$temppage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	if(($allpage-$currentpage)<5)
		while($temppage <= $allpage)
		{
			if($temppage==1)
			{
				echo "<a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			echo "<a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	else
		while($temppage <= $allpage)
		{
			if($temppage==$allpage)
			{
				echo " … <a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
				$temppage++;
				continue;
			}
			if(($temppage-$currentpage)>3)
			{
				$temppage++;
				continue;
			}
			echo "<a href='admin_user.php?columnid=$columnid&currentpage=$temppage'>".$temppage."</a> ";
			$temppage++;
		}
	
	if($currentpage==$allpage)
		echo "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
	else
		echo "| <a href='admin_user.php?columnid=$columnid&currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='admin_user.php?columnid=$columnid&currentpage=$allpage'>".gettext_r("lastPage")."</a>";
}
?>