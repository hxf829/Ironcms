<?php
include_once "../conn.php";
include_once "../library/basefunction.php";
include_once "../lang/envinit.php";
$functionarray = translatefunctioncode($_SESSION["functioncode"]);
echo "<div style=\"float: left;\" id=\"function_menu\" class=\"sdmenu\">\n";
//操作菜单
$query = "select id,columnname from I_column where parentid = 0";
$result = getresult($query);
//$count = getresultNumrows($result);
while(list($id , $columnname) = getresultRow($result))
{
	//echo getlogininfo("adminrole");
	if($functionarray[$id]!=NULL||getlogininfo("adminrole")==="0")
	{
		echo "<div>\n";
		echo "   <span>{$columnname}".gettext_r("manage")."</span>\n";
		echo "   <div>\n";
		echo "      <a target=\"main\" href=\"admin_article.php?action=add&columnid=".$id."\">".gettext_r("add").gettext_r("article")."</a>\n";
		echo "      <a target=\"main\" href=\"admin_article.php?columnid=".$id."\">".gettext_r("article").gettext_r("manage")."</a>\n";
		if($functionarray[$id]==="2"||getlogininfo("adminrole")==="0")
		{
			echo "      <a target=\"main\" href=\"admin_column.php?columnid=".$id."\">".gettext_r("column").gettext_r("manage")."</a>\n";
		}
		echo "      <a target=\"main\" href=\"admin_comment.php?columnid=".$id."\">".gettext_r("comment").gettext_r("manage")."</a>\n";
		if($functionarray[$id]==="2"||getlogininfo("adminrole")==="0")
		{
			echo "      <a target=\"main\" href=\"admin_field.php?columnid=".$id."\">".gettext_r("field").gettext_r("manage")."</a>\n";
		}
		echo "   </div>\n";
		echo "</div>\n";
	}
}
//用户管理
if(getlogininfo("adminrole")==="0")
{
	echo "<div>\n";
	echo "   <span><strong>".gettext_r("user").gettext_r("manage")."</strong></span>\n";
	echo "   <div>\n";
	echo "      <a target=\"main\" href=\"admin_user.php\">".gettext_r("user").gettext_r("manage")."</a>\n";
	echo "      <a target=\"main\" href=\"admin_admin.php\">".gettext_r("admin").gettext_r("manage")."</a>\n";
    echo "   </div>\n";
    echo "</div>\n";
}	
//调查管理
if($functionarray["vote"]==="1"||getlogininfo("adminrole")==="0")
{
	echo "<div>\n";
	echo "   <span><strong>".gettext_r("vote").gettext_r("manage")."</strong></span>\n";
	echo "   <div>\n";
	echo "      <a target=\"main\" href=\"admin_vote.php?columnid=0\">".gettext_r("vote").gettext_r("manage")."</a>\n";
    echo "   </div>\n";
    echo "</div>\n";
}
//系统管理
if(getlogininfo("adminrole")==="0")
{
	echo "<div>\n";
	echo "   <span><strong>".gettext_r("site").gettext_r("manage")."</strong></span>\n";
	echo "   <div>\n";
	echo "      <a target=\"main\" href=\"admin_sysconfig.php\">".gettext_r("siteInfo").gettext_r("manage")."</a>\n";	
	echo "      <a target=\"main\" href=\"admin_column.php?columnid=0\">".gettext_r("channel").gettext_r("manage")."</a>\n";
	echo "      <a target=\"main\" href=\"admin_template.php?type=3\">".gettext_r("siteIndex").gettext_r("template").gettext_r("manage")."</a>\n";	
	echo "      <a target=\"main\" href=\"admin_template.php?type=4\">".gettext_r("search").gettext_r("template").gettext_r("manage")."</a>\n";	
	echo "      <a target=\"main\" href=\"admin_template.php?type=1\">".gettext_r("column").gettext_r("page").gettext_r("template").gettext_r("manage")."</a>\n";
	echo "      <a target=\"main\" href=\"admin_template.php?type=2\">".gettext_r("article").gettext_r("page").gettext_r("template").gettext_r("manage")."</a>\n";
	echo "      <a target=\"main\" href=\"admin_mylabel.php\">".gettext_r("selfDefineTip").gettext_r("manage")."</a>\n";
	echo "      <a target=\"main\" href=\"admin_log.php\">".gettext_r("log").gettext_r("manage")."</a>\n";
	echo "      <a target=\"main\" href=\"admin_clearimg.php\">".gettext_r("clear").gettext_r("image")."</a>\n";
    echo "   </div>\n";
    echo "</div>\n";
}
//系统信息
	echo "<div>\n";
	echo "   <span><strong>".gettext_r("systemInfo")."</strong></span>\n";
    echo "</div>\n";
	echo "<span id='copyright'>".gettext_r("copyRight")."：GOW团队<br>".gettext_r("technicSupport")."：GOW团队</span>\n";
echo "</div>\n";
?>