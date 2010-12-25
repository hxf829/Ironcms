<?php
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
?>

<?php
/*showtemplatelist显示后台模板列表*/
function showtemplatelist($type)
{
	$tempresult = getresult("select count(*) as countoftemplate from I_template where templatetype=$type");
	
	$countoftemplate = getresultData($tempresult, 0, "countoftemplate");
	if($countoftemplate<1)
	{
		echo "<tr class='list'>\n";
		echo "<td colspan='4' align='center'>".gettext_r("haveNot").gettext_r("template")."</td>\n";
		echo "</tr>";
		return;
	}
	
	$query = "select * from I_template where templatetype=$type";
	$result = getresult($query);
	while($row = getresultArray($result))
	{
		echo "<tr class='list'>\n";
		echo "<td>　".$row["id"]."</td>";
		echo "<td>　".$row["templatename"]."</td>";
		echo "<td>　".$row["path"]."</td>";
		echo "<td align='center'>";
		echo "<a href=\"admin_template.php?type=$type&action=modify&id=".$row["id"]."\">".gettext_r("update")."</a> | <a href=\"javascript:if(confirm('".gettext_r("ifDelete")."'))jump('admin_template.php','delete',".$row["id"].")\">".gettext_r("delete")."</a>";
		echo "</td>";
		echo "</tr>\n";
	}
}
?>