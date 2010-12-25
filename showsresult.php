<?php
	session_start();
    include_once 'conn.php';
    include_once 'library/basefunction.php';
	include_once 'lang/envinit.php';
    include_once 'templatefunction/Iron.article.php';
	include_once 'templatefunction/Iron.column.php';
	include_once 'templatefunction/Iron.label.php';
	include_once 'templatefunction/Iron.search.php';
	
	$columnid = $_GET["columnid"];
	$templatefile = getroot()."/templates/searchresult.html";
	
	if (($columnid != NULL) && ($columnid != ''))
	{
		 $templateid = getcolumnformationBycolumnid($columnid,"searchtemplate");
		 $templatepath = getresultData(getresult("select * from I_template where id=$templateid"),0,"path");
		 $templatefile = getroot()."/templates/".$templatepath;	
	}
    //echo $templatefile;
    if(!file_exists($templatefile))
        die("The template file doesn'n exit!");
    $template = file_get_contents($templatefile);
	//如果模板被删除
	if(!$template)
		die("<script type='text/javascript'>alert('The template doesn't exists!')window.location='error.html'</script>");
	$template = translatelabel($template);
	$template = translateSearchlist($template);
    $template = translateArticlelist($template);
    $template = translateCommonlabel($template);
    echo $template;
?>