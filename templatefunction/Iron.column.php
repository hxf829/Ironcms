<?php
/*
*【columnlist】
*【articlelist(【columnid】,articlenum,titlelen,ifpage)】
*<h2>【#title】</h2>
*<b>【#time】</b>
*【/articlelist】
*【/columnlist】
*/
//include_once "../library/basefunction.php";
function translatecolumnlist($template)
{
    //匹配自定义文章列表标签正则
    $flag = "/【columnlist】([\s\S]*?)【\/columnlist】/";
	preg_match_all($flag, $template, $matches,PREG_SET_ORDER);
	//替换所有articlelist标签
	$html = $template;
	//echo $template."<br>".$flag;
	//得到需要循环的部分
    $str = $matches[0][1];
    //echo $str ;
    //得到子栏目id数组
    $columnid = $_GET["columnid"];
    $query = "select childcolumn,columnname from I_column where id=$columnid";
    $result = getresult($query);
    
    if(getresultNumrows($result)<1)
    {
        //没有才此栏目  
        return str_replace($str,"No such column!",$html);
        return;
    }
    
    $columnname = getresultData($result,0,"columnname");
    $childColumnId = getresultData($result,0,"childcolumn");
    if (($childColumnId == NULL) || ($childColumnId == 0) || ($childColumnId == ""))
    {
        //没有子栏目
        return str_replace($str,"No child column!",$html);
        return;
    }
    $temphtml = "";
    $childId = explode("|", $childColumnId);
    foreach ($childId as $id)
    {
		$tempstr = str_replace("【#columnid】","$id",$str);
		$tempstr = str_replace("【#columnname】",getcolumnformationBycolumnid($id,"columnname"),$tempstr);
		
        $temphtml .= $tempstr;
    }
    $html = str_replace($matches[0][0],$temphtml,$html);
	return $html;
}
?>