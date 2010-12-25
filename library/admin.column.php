<?php
//显示栏目结构，用于栏目管理
function showColumnstructure($columnid , $classindex=0)
{
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
					if($classindex==0)
					{
						echo "<tr style=\"height:24px;\">\n";
						echo "<td align='center' colspan='3'>".gettext_r("haveNot").gettext_r("column")."</td>";
						echo "</tr>\n";
					}
					return false;
				}
				$childId = explode("|",$childColumnId);
				foreach($childId as $id)
				{
					echo "<tr class='list'>\n";
					$getchildcolumnQuery = "select columnname,childcount from I_column where id=$id";
					
					$childColumn = getresult($getchildcolumnQuery);
					
					$childColumnname = getresultData($childColumn,0,"columnname");
					$childCount = getresultData($childColumn,0,"childcount");
					
					echo "<td>　".$id."</td>\n";
					echo "<td>　".space($classindex).$childColumnname."</td>\n";
					echo "<td align='center'>";
					echo "　";
					//如果为大栏目调整，不出现添子栏目菜单
					if($columnid!=0)
					{
						echo "<a href=\"admin_column.php?action=add&columnid=".$id."\">".gettext_r("add").gettext_r("child").gettext_r("column")."</a>";
						echo " ｜ ";
					}
					echo "<a href=\"javascript:jump('admin_column.php','modify',".$id.")\">".gettext_r("update").gettext_r("column").gettext_r("attribute")."</a>";
					echo " ｜ ";
					if($columnid!=0)
					{
    					echo "<a href=\"admin_article.php?action=add&columnid=".$id."\">".gettext_r("add").gettext_r("article")."</a>";
    					echo " ｜ ";
					}
					echo "<a href=\"javascript:if(confirm('".gettext_r("deleteColumnTip")."'))jump('admin_column.php','delete',".$id.")\">".gettext_r("delete")."</a>";
					//echo " ｜ ";
					//如果有子栏目则显示管理子栏目
/*					if($childCount > 0)
						echo "<a href=\"admin_column.php?columnid=".$id."\">管理子栏目($childCount)</a>\n";
					else
						echo "<a href=\"#\">管理子栏目($childCount)</a>\n";*/
					echo "</tr>\n";
					//如果为大栏目调整，则不递归显示子栏目
					if($columnid!=0)
						showColumnstructure($id , $classindex+1);
				}
			}
			else
				return false;
}
?>