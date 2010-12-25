<?php
    include_once 'conn.php';
    include_once 'library/basefunction.php';
    include_once 'templatefunction/Iron.comment.php';
	include_once 'templatefunction/Iron.label.php';
	readcache();
    header('Content-Type: text/html; charset=UTF-8'); 
    //$articleid = $_GET["articleid"];
    //echo $articleid;
    //$templateid = getcolumnformation($articleid,"articletemplate");

    //$templatepath = getresultData(getresult("select * from I_template where id=$templateid"),0,"path");
    $templatefile = getroot()."/templates/comment.html";
    //echo $templatefile;
    $template = file_get_contents($templatefile);
    $template = translateCommentlist($template); 
    $template = translateCommentCommonlabel($template);
	$template = translatelabel($template);
    echo $template;
	ob_flush();
	buildcache($template);
?>