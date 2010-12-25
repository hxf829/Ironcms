<?php
//翻译模板中的普通标签
function translatemylabel($mylabel)
{
	$result = getresult("select * from I_mylabel where labelname='$mylabel'");
	//echo "select * from I_mylabel where labelname='$mylabel'";
	if(getresultNumrows($result)<1)
	{
		return $mylabel;
	}
	else
	return getresultData($result,0,"labelcontent");
}	
function translatelabel($template)
{
	$flag = "/【#MY_[\d\w]*】/";
	preg_match_all($flag, $template, $matches,PREG_SET_ORDER);
	foreach($matches as $matche)
	{
		$template = str_replace($matche,translatemylabel($matche[0]),$template);
	}
    
    return $template;
}
?>