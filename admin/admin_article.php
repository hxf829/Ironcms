<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>添加文章</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				liststyle_mousechange();
			}
		);
</script>
</head>
<body>
<?php
		include "../conn.php";
		include_once "../library/basefunction.php";
		include_once "../lang/envinit.php";
		include "../library/admin.article.php";
		$functionarray = translatefunctioncode($_SESSION["functioncode"]);
		$columnid = $_GET["columnid"];
		$action = $_GET["action"];
		$preurl = $_GET["url"];
		$currentpage = ($_GET["currentpage"]==NULL || $_GET["currentpage"]<=0)?1:$_GET["currentpage"];
		//检查权限
		$functionarray = translatefunctioncode($_SESSION["functioncode"]);
		//消除普通管理员无法审核文章BUG
		if($_GET["articleid"]!=NULL)
			$columnid = getarticleinfo($_GET["articleid"], "columnid");
		//得到频道id
		$channelid = $columnid;
		//echo "郝学峰";
		for(;;)
		{
			if($channelid==null||$channelid=="")
				break;
			$tempid = getcolumnformationBycolumnid($channelid,"parentid");
			if($tempid==null||$tempid==""||$tempid=="0")
			{
				break;
			}
			$channelid = $tempid;
		}
		//对文章没有权限
		if($_GET["articleid"]!=NULL&&$functionarray[$channelid]=="1"&&getarticleinfo($_GET["articleid"], "adminid")!=getlogininfo("adminid"))
		{
			//如果不是超管或频道管理员
			die("<script type='text/javascript'>alert('".gettext_r("noRight")."');history.back('-1');</script>\n");
		}
		//对此频道没有权限
		//print_r($functionarray);
		if($functionarray[$channelid]!="1"&&$functionarray[$channelid]!="2"&&getlogininfo("adminrole")!="0")
		{
			die("<script type='text/javascript'>alert('".gettext_r("noRight")."');history.back('-1');</script>\n");
		}
?>
<?php
	switch($action)
	{
		case "add":
		if($_POST["submmit2"]==gettext_r("submit"))
			{
				$columnid = $_POST["columnid"];
				$title = $_POST["title"];
				$keywords = $_POST["keywords"];
				$author = $_POST["author"];
				$source = $_POST["source"];
				$addtime = $_POST["addtime"];
				$modifytime = $_POST["modifytime"];
				$notes = $_POST["notes"];
				$contents = transbadchar($_POST["contents"]);
				//echo $contents;
				$picurl = $_POST["picurl"];
				$ifpass = $_POST["ifpass"]!=NULL?$_POST["ifpass"]:0;
				//如果已存在此题目的文章则提示错误
				if(getresultNumrows(getresult("select * from I_article where title='$title' and columnid=$columnid"))>0)
					die("<script type='text/javascript'>alert('".gettext_r("articleAlreadyExist")."');history.back('-1');</script>\n");
				//echo nl2br($contents);
				//自定义字段
				$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($columnid));
				$sdef_fieldsString = "";
				$sdef_fieldsValueString = "";
				while($row = getresultarray($sdef_fields))
				{
					if($_POST[$row["fieldname"]]!=null&&$_POST[$row["fieldname"]]!="")
					{
						$sdef_fieldsString .= (",".$row["fieldname"]);
						$sdef_fieldsValueString .= (",'".$_POST[$row["fieldname"]]."'");
					}
				}
				
				$query = "insert into I_article(adminid,columnid,addtime,modifytime,title,keywords,author,source,notes,contents,picurl,ifpass".$sdef_fieldsString.") values(".getlogininfo("adminid").",$columnid,'$addtime','$modifytime','$title','$keywords','$author','$source','$notes','$contents','$picurl',$ifpass".$sdef_fieldsValueString.")";
				//die( $query);
				if(getresult($query))
					echo "<script type='text/javascript'>alert('".gettext_r("article").gettext_r("add").gettext_r("success")."');window.location=window.location;</script>\n";					
				else
					echo "<script type='text/javascript'>alert('".gettext_r("article").gettext_r("add").gettext_r("fail")."');history.back('-1');</script>\n";

			}
?>
<form id="form1" name="form1" method="post" action="" onsubmit="return article_form_check()">
<table width="100%" cellspacing="0" cellpadding="3" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
  <tr>
    <td class="label"><?php echo gettext_r("column"); ?>：</td>
    <td class='attributeinput'>
	<select name="columnid"><?php showcolumnlist($columnid);?></select>	</td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("articleTitle"); ?>：</td>
    <td class='attributeinput'><input type="text" name="title" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("keywords"); ?>：</td>
    <td class='attributeinput'><input type="text" name="keywords" />*<?php echo gettext_r("keywordsFillNotes"); ?></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("author"); ?>：</td>
    <td class='attributeinput'><input type="text" name="author" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("source"); ?>：</td>
    <td class='attributeinput'><input type="text" name="source" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("addTime"); ?>：</td>
    <td class='attributeinput'><input type="text" name="addtime" value="<?php echo date("Y-m-d H:i:s"); ?>" /></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("updateTime"); ?>：</td>
    <td class='attributeinput'><input type="text" name="modifytime" value="<?php echo date("Y-m-d H:i:s"); ?>" /></td>
  </tr>
  <!--自定义字段-->
   <tr>
    <td class='label'><?php echo gettext_r("field"); ?>：</td>
    <td class='attributeinput'>
    <?php
		$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($columnid));
		//echo "select * from I_field where columnid=".getChanelidByColumnid($columnid);
		while($row = getresultarray($sdef_fields))
		{
			echo $row["info"].":<input type='text' name='".$row["fieldname"]."'><br>";
		}
	?>
    </td>
  </tr>
  <!--自定义字段-->
  <tr>
    <td class='label'><?php echo gettext_r("notes"); ?>：</td>
    <td class='attributeinput'><textarea name="notes" rows="5"></textarea></td>
  </tr>
  <tr>
    <td class='label'><?php echo gettext_r("contents"); ?>：<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><?php echo gettext_r("picOverView"); ?>：<br />
      <img height="88" width="126" id="preview" name="preview" src="images/nopic.gif" /></td>
    <td class='attributeinput'>
	<?php
	include "../fckeditor/fckeditor.php";
	$FCKeditor = new FCKeditor('contents') ;
	$FCKeditor->Height = 500;
	$FCKeditor->Create() ;
	?>	</td>
  </tr>
 <?php
  if($functionarray[$columnid]==2||getlogininfo("adminrole")==="0")
  {
	  echo "<tr>";
	  echo "  <td class='label'>".gettext_r("ifPass")."：</td>";
	  echo "  <td>".gettext_r("yes")."<input type='radio' value='1' name='ifpass'/>".gettext_r("no")."<input type='radio' value='0' name='ifpass' checked='checked' /></td>";
	  echo "</tr>";
  }
  ?>
  <tr>
  	<td class='label'>缩略图：</td>
	<td><input name='picurl' type='text' id='picurl' size='56' maxlength='200'>              <span class="sblack13">用于在首页的图片文章处显示</span> <br><span class="sblack13">直接从上传图片中选择：</span>              <select name='piclist' id='piclist' onChange="picurl.value=this.value;if(this.value!='')preview.src=this.value;else preview.src='image/nopic.gif'">                <option selected value="">不指定首页图片</option>              </select></td>
  </tr>
  <tr>
    <td style="border-width:0px;"></td>
    <td height="60px;" style="border-width:0px;"><input type="submit" value="<?php echo gettext_r("submit"); ?>" name="submmit2"/>&nbsp;&nbsp;<input name="reset" type="reset" value="<?php echo gettext_r("cancle"); ?>" /></td>
  </tr>
</table>
</form>
<?php
			break;
		case "modify":
			$articleid = $_GET["articleid"];
			$columnid = $_GET["columnid"];
			if($_POST["submmit2"]==gettext_r("submit"))
			{
				$columnid = $_POST["columnid"];
				$title = $_POST["title"];
				$keywords = $_POST["keywords"];
				$author = $_POST["author"];
				$source = $_POST["source"];
				$addtime = $_POST["addtime"];
				$modifytime = $_POST["modifytime"];
				$notes = $_POST["notes"];
				$contents = transbadchar($_POST["contents"]);
				//echo $contents;
				$picurl = $_POST["picurl"];
				$ifpass = $_POST["ifpass"];
				
				//echo nl2br($contents);
				$return = NULL;
				/*echo "<script type\"text/javascript\">document.write(\"".$contents."\")</script>";*///输出文章
				
				//自定义字段
				$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($columnid));
				$sdef_fieldsUpdateString = "";
				while($row = getresultarray($sdef_fields))
				{
					if($_POST[$row["fieldname"]]!=null&&$_POST[$row["fieldname"]]!="")
						$sdef_fieldsUpdateString .= (",".$row["fieldname"]."='".$_POST[$row["fieldname"]]."'");
				}
				
				$query = "update I_article set columnid=$columnid,addtime='$addtime',modifytime='$modifytime',title='$title',keywords='$keywords',author='$author',source='$source',notes='$notes',contents='$contents',picurl='$picurl',ifpass=$ifpass".$sdef_fieldsUpdateString." where id = $articleid";
				//die( $query);
				//die();
				$return = getresult($query);
				if($return!=false)
					echo "<script type='text/javascript'>alert('".gettext_r("update").gettext_r("success")."');window.location=\"$preurl\";</script>\n";					
				else
					echo "<script type='text/javascript'>alert('".gettext_r("update").gettext_r("fail")."');history.back('-1');</script>\n";
				die();

			}
			//echo "select * from I_article where id =".$articleid;
			$result = getresult("select * from I_article where id =".$articleid);
			
			$columnofarticleid = getresultData($result, 0, "columnid");
			$title = getresultData($result, 0, "title");
			$keywords = getresultData($result, 0, "keywords");
			$author = getresultData($result, 0, "author");
			$source = getresultData($result, 0, "source");
			$addtime = getresultData($result, 0, "addtime");
			$notes = getresultData($result, 0, "notes");
			$contents = getresultData($result, 0, "contents");//消除单引号的bug
			$picurl = getresultData($result, 0, "picurl");
			$ifpass = getresultData($result, 0, "ifpass");
?>
<form id="form1" name="form1" method="post" action="" onsubmit="return article_form_check()">
<table width="100%" cellspacing="0" cellpadding="3" border="1" bordercolor="#FFFFFF" style="border-collapse:collapse">
  <tr>
    <td class='label'>所属栏目：</td>
    <td class='attributeinput'>
	<select name="columnid"><?php showcolumnlist($columnid, $columnofarticleid);?></select>	</td>
  </tr>
  <tr>
    <td class='label'>文章标题：</td>
    <td class='attributeinput'><input value="<?php echo $title; ?>" type="text" name="title" /></td>
  </tr>
  <tr>
    <td class='label'>关键字：</td>
    <td class='attributeinput'><input  value="<?php echo $keywords; ?>" type="text" name="keywords" />*如果有多个关键字，请用逗号隔开</td>
  </tr>
  <tr>
    <td class='label'>作者：</td>
    <td class='attributeinput'><input value="<?php echo $author; ?>" type="text" name="author" /></td>
  </tr>
  <tr>
    <td class='label'>来源：</td>
    <td class='attributeinput'><input value="<?php echo $source; ?>" type="text" name="source" /></td>
  </tr>
  <tr>
    <td class='label'>添加时间：</td>
    <td class='attributeinput'><input type="text" name="addtime" value="<?php echo $addtime; ?>" /></td>
  </tr>
  <tr>
    <td class='label'>修改时间：</td>
    <td class='attributeinput'><input type="text" name="modifytime" value="<?php echo date("Y-m-d H:i:s"); ?>" /></td>
  </tr>
  <!--自定义字段-->
   <tr>
    <td class='label'>属性：</td>
    <td class='attributeinput'>
    <?php
		$sdef_fields = getresult("select * from I_field where columnid=".getChanelidByColumnid($columnid));
		while($row = getresultarray($sdef_fields))
		{
			echo $row["info"].":<input type='text' name='".$row["fieldname"]."' value='".getresultData($result, 0, $row["fieldname"])."'><br>";
		}
	?>
    </td>
  </tr>
  <!--自定义字段-->
  <tr>
    <td class='label'>简介：</td>
    <td class='attributeinput'><textarea name="notes"><?php echo $notes; ?></textarea></td>
  </tr>
  <tr>
    <td class='label'>正文：<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />缩略图预览：<br />
      <img height="88" width="126" id="preview" name="preview" src="<?php if($picurl==NULL||$picurl=="")echo "images/nopic.gif";else echo $picurl; ?>" /></td>
    <td class='attributeinput'>
	<?php
	include "../fckeditor/fckeditor.php";
	$FCKeditor = new FCKeditor('contents') ;
	$FCKeditor->Value = $contents;
	$FCKeditor->Height = 500;
	$FCKeditor->Create() ;
	?>	</td>
  </tr>
<?php
  if($functionarray[$columnid]==2||getlogininfo("adminrole")==="0")
  {
  	 echo "<tr>";
	 echo "  <td class='label'>是否通过：</td>";
	 echo "<td>";
	 if($ifpass==0)
		echo "是<input type=\"radio\" value=\"1\" name=\"ifpass\" />否<input type=\"radio\" value=\"0\" name=\"ifpass\"  checked=\"checked\" />";	
	 else
		echo "是<input type=\"radio\" value=\"1\" name=\"ifpass\" checked=\"checked\" />否<input type=\"radio\" value=\"0\" name=\"ifpass\" />";
	 echo "</td>";
	 echo "</tr>";
  }
?>
  <tr>
  	<td class='label'>缩略图：</td>
	<td><input name='picurl' value="<?php echo $picurl; ?>" type='text' id='picurl' size='56' maxlength='200'>              <span class="sblack13">用于在首页的图片文章处显示</span> <br><span class="sblack13">直接从上传图片中选择：</span>              <select name='piclist' id='piclist' onChange="picurl.value=this.value;if(this.value!='')preview.src=this.value;else preview.src='image/nopic.gif'">                <option selected value="">不指定首页图片</option>              </select></td>
  </tr>
  <tr>
    <td style="border-width:0px;"></td>
    <td height="60px;" style="border-width:0px;"><input type="submit" value="提交" name="submmit2"/>&nbsp;&nbsp;<input name="reset" type="reset" value="取消" /></td>
  </tr>
</table>
</form>
<?php
			break;
		case "delete":
			if(!getresult("delete from I_article where id=".$_GET["articleid"]))
				echo "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("fail")."');window.location=\"$preurl\";</script>";
			else
				echo "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("success")."');window.location=\"$preurl\";</script>";
			break;
		case "pass":
			getresult("update I_article set ifpass=".$_GET["ifpass"]." where id=".$_GET["articleid"]);
			break;
		default:
		echo "<div id='navigation'>".gettext_r("quickLink")."：";
		echo "<a href=\"admin_article.php?action=add&columnid=".$columnid."\">".gettext_r("add").gettext_r("article")."</a>\n";
		echo "</div>";
		
		echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
		echo "<tr class='header'>\n";
		echo "<td align='center' width='40'>".gettext_r("checkIn")."</td>\n";
		echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
		echo "<td align='center' width='100'>".gettext_r("column")."</td>\n";
		echo "<td align='center'>".gettext_r("articleTitle")."</td>\n";
		echo "<td align='center' width='100'>".gettext_r("author")."</td>\n";
		echo "<td align='center' width='60'>".gettext_r("hits")."</td>\n";
		echo "<td align='center' width='80'>".gettext_r("ifPass")."</td>\n";
		echo "<td align='center' width='100'>".gettext_r("operate")."</td>\n";
		echo "</tr>\n";
		showarticle($columnid, $currentpage);
		echo "</table>\n";
		echo "<div style='height:5px;'></div>";
		echo "<input type='checkbox' id='checkall' onclick='checkall()' value='全选' /><span>".gettext_r("checkAll")."　　</span> ";
		echo "<input type='button' onclick=\"deleteall('admin_article.php')\" value='".gettext_r("deleteAll")."' />";
		if($functionarray[$columnid]==="2"||getlogininfo("adminrole")==="0")
		{
			echo "<input type='button' onclick='passall(1)' value='".gettext_r("pass")."' />";
			echo "<input type='button' onclick='passall(0)' value='".gettext_r("canclePass")."' />";
		}
		echo "<div id='showpage'>";
		showpage($columnid, $currentpage);
		echo "</div>";
	}
?>
</body>
</html>
