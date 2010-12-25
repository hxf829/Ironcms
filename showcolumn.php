<?php
	session_start();
    include_once 'conn.php';
    include_once 'library/basefunction.php';
	include_once 'lang/envinit.php';
    include_once 'templatefunction/Iron.article.php';
	include_once 'templatefunction/Iron.column.php';
	include_once 'templatefunction/Iron.label.php';
    $columnid = $_GET["columnid"];
    //echo $articleid;
	if(getcolumnformationBycolumnid($columnid,"isopen")=="0")
	{
		if(getaffectedrows()<1)
		{
			//如果没有此栏目，跳转到error.html
			die("<script type='text/javascript'>window.location='error.html'</script>");
		}
		die("This column is locked!");
	}
	readcache();
    $templateid = getcolumnformationBycolumnid($columnid,"columntemplate");
    $templatepath = getresultData(getresult("select * from I_template where id=$templateid"),0,"path");
    $templatefile = getroot()."/templates/".$templatepath;
    //echo $templatefile;
    if(!file_exists($templatefile))
        die("The template file doesn'n exit!");
    $template = file_get_contents($templatefile);
	//如果模板被删除
	if(!$template)
		die("<script type='text/javascript'>alert('The template doesn't exists!')window.location='error.html'</script>");
    $template = translatelabel($template);
	$template = translatecolumnlist($template);
    $template = translateArticlelist($template);
    $template = translateCommonlabel($template); 
    echo $template;
	ob_flush();
	buildcache($template);
?>