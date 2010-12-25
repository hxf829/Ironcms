<?php
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
$childcolumnString = "";//申明全局变量以供showarticle和getchildcolumnid_improveed使用以避免安全模式未开启情况下的错误
?>
<?php
//显示本频道所有自定义字段
function showfield($columnid)
{
	$result = getresult("select * from I_field where columnid=$columnid");
	
	if(getresultnumrows($result)<1)
	{
	    echo "<tr>";
		echo "<td colspan='6' height='25' align='center'>".gettext_r("haveNot").gettext_r("field")."</td>";
		echo "<tr>";
		return;
	}
	
	while($row = getresultarray($result))
	{
		echo "<tr class='list'>";
		echo "<td align='center'>".$row["id"]."</td>\n";
		echo "<td align='center'>".$row["fieldname"]."</td>";
		echo "<td align='center'>".$row["info"]."</td>";

		echo "<td align='center' width='100'>";
		echo "<a href=\"admin_field.php?action=modify&fieldid=".$row["id"]."&columnid=$columnid\">".gettext_r("update")."</a>";
		echo " ｜ ";
		echo "<a href=\"javascript:if(confirm('".gettext_r("ifDelete")."'))jump('admin_field.php','delete',".$row["id"].")\">".gettext_r("delete")."</a>";
		echo "</td>\n";
		echo "</tr>";
	}
}
?>