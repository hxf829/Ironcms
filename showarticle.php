<?php
	//如果缓存中存在，则直接输出缓存
	session_start();
    include_once 'conn.php';
    include_once 'library/basefunction.php';
	include_once 'lang/envinit.php';
    include_once 'templatefunction/Iron.article.php';
	include_once 'templatefunction/Iron.label.php';
    $articleid = $_GET["articleid"];
	getresult("update I_article set hits=hits+1 where id = $articleid and ifpass=1");
	
	//readcache();
	
    //echo $articleid;
    $templateid = getcolumnformation($articleid,"articletemplate");

    $templatepath = getresultData(getresult("select * from I_template where id=$templateid"),0,"path");
    $templatefile = getroot()."/templates/".$templatepath;
    //echo $templatefile;
    $template = file_get_contents($templatefile);
	if(!$template)
		die("<script type='text/javascript'>alert('The template doesn't exists!')window.location='error.html'</script>");
	$template = translatelabel($template);
    $template = translateArticlelist($template); 
    $template =  translateCommonlabel($template);
	echo $template;
	ob_flush();
	
	buildcache($template);
?>