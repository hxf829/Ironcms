<?php
include '../conn.php';
$result = getresult("select * from I_article where ifpass=1 and columnid=47 order by id desc limit 0,5");
if(getresultNumrows($result)<1)
	die("No article!");
while ($row = getresultArray($result))
{
		echo "<div class='content'>";
        echo "<div class='date'>".$row["addtime"]."</div>";
        echo "<div class='contenttitle'><a href='showarticle.php?articleid=".$row["id"]."'>".$row["title"]."</a></div>";
        echo "<div class='notes'>".$row["notes"]."</div>";
        echo "<div class=\"readmore\"><a href='showarticle.php?articleid=".$row["id"]."'>Read more -></a></div>";
        echo "</div>";
        echo "<div style='height:9px;'></div>";

    echo "<script type'javascript'>initflash();</script>";
}
?>