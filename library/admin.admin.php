<?php
//showadminlist显示管理员列表
function showadminlist($adminid=0)
{
	$result = getresult("select * from I_admin order by lasttime desc");
	while($row = getresultArray($result))
	{
		echo "<tr class='list'>\n";
		echo "<td align='center'>";
		if(getlogininfo("adminid")==$row["id"])
			echo "<input type='checkbox' disabled name='list' value='".$row["id"]."' />";
		else
			echo "<input type='checkbox' name='list' value='".$row["id"]."' />";		
		echo "</td>";
		echo "<td>　".$row["id"]."</td>";
		echo "<td>　".$row["adminname"]."</td>";
		echo "<td>　";
		if($row["adminrole"]==0)
			echo gettext_r("super").gettext_r("manager");
		else
			echo gettext_r("common").gettext_r("manager");
		echo "</td>";
		echo "<td>　".$row["lastip"]."</td>";
		echo "<td>　".$row["lasttime"]."</td>";
		echo "<td>　".$row["logintimes"]."</td>";
	
		echo "<td>";
		if(getlogininfo("adminid")!=$row["id"])
			echo "　<a href=\"javascript:jump('admin_admin.php','modify',".$row["id"].")\">".gettext_r("update").gettext_r("power")."</a> ";
		else
			echo "　<span style='color:#cccccc'>".gettext_r("update").gettext_r("power")."</span>";
		echo "</td>";
		echo "</tr>\n";
	}
}
function showpowerlist($adminid=0)
{
	if($adminid!=0)
	{
		$tempresult = getresult("select * from I_admin where id=$adminid");
		$functioncode = getresultData($tempresult,0,"functioncode");
		$functionarray = translatefunctioncode($functioncode);
		$result = getresult("select * from I_column where parentid=0");
		while($row = getresultArray($result))
		{
			 if($functionarray[$row["id"]]==="1")
			 {
				 echo "<tr>\n";
				 echo "<td><input checked=\"true\" type=\"checkbox\" name=\"columnid\" value=\"".$row["id"]."\" />".$row["columnname"]."</td>";
				 echo "<td><input checked=\"checked\" type=\"radio\" name=\"".$row["id"]."\" value=\"1\" />".gettext_r("editer")."<input type=\"radio\" name=\"".$row["id"]."\" value=\"2\" />".gettext_r("column").gettext_r("manager")."</td>";
				 echo "</tr>";
				 echo "<tr class='segmentline'><td colspan='2'></td></tr>";	
			 }
			 elseif($functionarray[$row["id"]]==="2")
			 {
 				 echo "<tr>\n";
				 echo "<td><input checked=\"true\" type=\"checkbox\" name=\"columnid\" value=\"".$row["id"]."\" />".$row["columnname"]."</td>";
				 echo "<td><input type=\"radio\" name=\"".$row["id"]."\" value=\"1\" />".gettext_r("editer")."<input checked=\"checked\" type=\"radio\" name=\"".$row["id"]."\" value=\"2\" />".gettext_r("column").gettext_r("manager")."</td>";
				 echo "</tr>";
				 echo "<tr class='segmentline'><td colspan='2'></td></tr>";	
			 }
			 else
			 {
				 echo "<tr>\n";
				 echo "<td><input type=\"checkbox\" name=\"columnid\" value=\"".$row["id"]."\" />".$row["columnname"]."</td>";
				 echo "<td><input type=\"radio\" name=\"".$row["id"]."\" value=\"1\" />".gettext_r("editer")."<input type=\"radio\" name=\"".$row["id"]."\" value=\"2\" />".gettext_r("column").gettext_r("manager")."</td>";
				 echo "</tr>";
				 echo "<tr class='segmentline'><td colspan='2'></td></tr>";
			 }
		}
		if($functionarray["vote"]==="1")
		{
			echo " <tr>";
			echo " <td colspan=\"2\"><input type=\"checkbox\" checked=\"true\" name=\"voteadmin\" value=\"1\" />".gettext_r("vote").gettext_r("manage")."</td>";
			echo "  </tr>";
		}
		else
		{
			echo " <tr>";
			echo " <td colspan=\"2\"><input type=\"checkbox\" name=\"voteadmin\" value=\"1\" />".gettext_r("vote").gettext_r("manage")."</td>";
			echo "  </tr>";
		}
		return;
	}
	$result = getresult("select * from I_column where parentid=0");
	while($row = getresultArray($result))
	{
		 echo "<tr>\n";
         echo "<td><input type=\"checkbox\" name=\"columnid\" value=\"".$row["id"]."\" />".$row["columnnamezh"]."</td>";
         echo "<td><input type=\"radio\" name=\"".$row["id"]."\" value=\"1\" />".gettext_r("editer")."<input type=\"radio\" name=\"".$row["id"]."\" value=\"2\" />".gettext_r("column").gettext_r("manager")."</td>";
  		 echo "</tr>";
		 echo "<tr class='segmentline'><td colspan='2'></td></tr>";
	}
	echo " <tr>";
	echo " <td colspan=\"2\"><input type=\"checkbox\" name=\"voteadmin\" value=\"1\" />".gettext_r("vote").gettext_r("manage")."</td>";
	echo "  </tr>";
}
?>