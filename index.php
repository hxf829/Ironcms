<?php
	session_start();
	$_DEBUG=true;//调试模式
    include_once 'conn.php';
    include_once 'library/basefunction.php';
	include_once 'lang/envinit.php';

    include_once 'templatefunction/Iron.article.php';
	include_once 'templatefunction/Iron.column.php';
	include_once 'templatefunction/Iron.label.php';
	readcache();

	$siteconfig = getresult("SELECT * FROM I_siteconfig LIMIT 0 , 1");
	
	//如果没有网站配置项
	if(getresultNumrows($siteconfig)<1)
		die("<script type='text/javascript'>window.location='error.html'</script>");
		
    $templateid = getresultData($siteconfig, 0, "indextemplate");
	$templateinfo = getresult("select * from I_template where id=$templateid limit 0,1");
	
	if(getresultNumrows($templateinfo)<1)
		die("<script type='text/javascript'>window.location='error.html'</script>");
		
    $templatepath = getresultData($templateinfo,0,"path");

    $templatefile = getroot()."/templates/".$templatepath;
    //echo $templatefile;
    if(!file_exists($templatefile))
        die("The template file doesn'n exit!");
    $template = file_get_contents($templatefile);
	//如果模板被删除
	if(!$template)
		die("<script type='text/javascript'>alert('The template doesn't exists!')window.location='error.html'</script>");
	$template = translatelabel($template);
    $template = translateArticlelist($template);
    $template = translateCommonlabel($template);
    echo $template;
	ob_flush();
	buildcache($template);
?>