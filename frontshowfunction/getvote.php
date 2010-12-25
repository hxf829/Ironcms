<?php
include '../conn.php';
$voteid = $_GET["voteid"];
$result = getresult("select * from I_vote where id=$voteid");
//如果调查不存在则不显示调查
if($result==NULL||getresultNumrows($result)<1)
	die("");
	
echo "<div id='vote'>";
echo "<form name='voteform'  target='_blank' method='post' action='showvoteresult.php?voteid=".$voteid."'>\n";
$title = getresultData($result,0,"title");
echo "<div id='votetitle'>$title</div>";
$attrcount = getresultData($result,0,"attrcount");
$type = getresultData($result,0,"type");
//Form表单
for($i=1;$i<$attrcount+1;$i++)
{
	echo "<div class='voteoption'>";
	echo "<input type='hidden' name='votetype' value='".$type."'>";
	if($type==0)
		echo "<span><input type='radio' name='option' value='$i'/></span>";
	else
		echo "<span><input type='checkbox' name='option[]' value='$i'/></span>";
	echo "<span class='optionvalue'>".getresultData($result,0,"option".$i)."</span>";
	echo "</div>";
}
echo "<input type='submit' id='votebutton' value='Vote'>\n";
echo "</form>";
echo "</div>";
?>