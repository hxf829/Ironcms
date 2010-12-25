<?Php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>模板管理</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>
<script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				liststyle_mousechange();
				lockeachother();
			}
		);
</script>
</head>
<body>
<?php
		include_once "../conn.php";
		include_once '../library/basefunction.php';
		include_once "../lang/envinit.php";
		include_once "../library/admin.template.php";
		$type = $_GET["type"];//模板类型1为栏目模板，2为文章模板，3为网站首页模板,4为搜索模板
		$action = $_GET["action"];
		$templateid = $_GET["id"];
		$preurl = $_GET["url"];
		if(getlogininfo("adminrole")==NULL||getlogininfo("adminrole")!="0")
			die(gettext_r("noRgiht"));
?>
<?php
	switch($action)
	{
		case "delete":
		    //从数据库中删除，并删除文件
		    $result = getresult("select * from I_template where id =".$_GET["id"]);
		    unlink(getroot()."/templates/".getresultData($result,0,"path"));
		    if(!getresult("delete from I_template where id=".$_GET["id"]))
				die( "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("fail")."');window.location=\"$preurl\";</script>");
			else
				die( "<script type=\"text/javascript\">alert('".gettext_r("delete").gettext_r("success")."');window.location=\"$preurl\";</script>");
			break;
		case "add"   :
		    if($_POST["submit"]==gettext_r("submit"))
		    {
		        //存储模板
		        $templatename = trim($_POST["templatename"]);
		        if($templatename=="")
		            die("<script type='text/javascript'>alert('模板名字不能为空');history.back(-1);</script>");
				if(getresultNumrows(getresult("select * from I_template where templatename='$templatename'"))>0)
					die("<script type='text/javascript'>alert('已存在此名字的模板');history.back('-1');</script>\n");
		        if(!empty($_FILES["templatefile"][name]))
		        {
		            $file = $_FILES["templatefile"];
		            $pos=strrpos($file[name],"."); //取得文件名中后缀名的开始位置
                    $ext=substr($file[name],$pos+1);//取得后缀名，包括点号
                    if($ext != "tpl")
                    {
                        echo "<script type='text/javascript'>alert('文件类型错误');history.back(-1);</script>";
                    }
                    else 
                    {
                        $filename = $file[name];
                        $tempfilename = $file[name];
                        //echo $tempfilename;
                        $index = 1;
                        for(;;)
                        {
                            if(file_exists(getroot()."/templates/".$tempfilename))
                            {
                                $tempfilename = substr($file[name],0,$pos)."(".$index.").".$ext;
                                $index++;
                            }
                            else
                            {
                                break;
                            }
                        }
                        $filename = $tempfilename;
                        if(!move_uploaded_file($file[tmp_name],getroot()."/templates/".$filename))
                            die("<script type='text/javascript'>alert('文件上传失败');history.back(-1);</script>");
                        if(!getresult("insert into I_template(templatetype,templatename,path) values($type,'$templatename','$filename')"))
                        {
                            unlink(getroot()."/templates/".$filename);
                            die("<script type='text/javascript'>alert('数据库添加失败');history.back(-1);</script>");
                        }
                        die( "<script type='text/javascript'>alert('模板添加成功');window.location='admin_template.php?type=$type'</script>");
                    }
		        }
		        else 
		        {
		            die("<script type='text/javascript'>alert('请选择要上传的文件文件');history.back(-1);</script>");
		        }
		    }
?>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<table width="100%">
  <tr>
	<td class='label' width="150px"><?php echo gettext_r("template").gettext_r("name"); ?>：</td>
    <td><input type="text" name="templatename" /></td>
  </tr>
  <tr>
	<td class='label'><?php echo gettext_r("template").gettext_r("file"); ?>：</td>
    <td><input type="file" name="templatefile" /></td>
  </tr>
  <tr>
  	<td></td>
	<td><input type="submit" name="submit" value="<?php echo gettext_r("submit"); ?>" /><input type="reset" value="<?php echo gettext_r("cancle"); ?>" /></td>
  </tr>
</table>
</form>
<?php
			break;
		case "modify":
		    $template = getresult("select * from I_template where id =$templateid");
	        if($_POST["submit"]==gettext_r("submit"))
		    {
		        //存储模板
				unlink(getroot()."/templates/".getresultData($template,0,"path"));
		        $templatename = trim($_POST["templatename"]);
		        if(!empty($_FILES["templatefile"][name]))
		        {
		            $file = $_FILES["templatefile"];
		            $pos=strrpos($file[name],"."); //取得文件名中后缀名的开始位置
                    $ext=substr($file[name],$pos+1);//取得后缀名，包括点号
                    if($ext != "tpl")
                    {
                        echo "<script type='text/javascript'>alert('文件类型错误');history.back(-1);</script>";
                    }
                    else 
                    {
                        $filename = $file[name];
                        $tempfilename = $file[name];
                        //echo $tempfilename;
                        $index = 1;
                        for(;;)
                        {
                            if(file_exists(getroot()."/templates/".$tempfilename))
                            {
                                $tempfilename = substr($file[name],0,$pos)."(".$index.").".$ext;
                                $index++;
                            }
                            else
                            {
                                break;
                            }
                        }
                        $filename = $tempfilename;
                        if(!move_uploaded_file($file[tmp_name],getroot()."/templates/".$filename))
                            die("<script type='text/javascript'>alert('文件上传失败');history.back(-1);</script>");
                        if(!getresult("update I_template set templatename='$templatename',path='$filename' where id=$templateid"))
                            die("<script type='text/javascript'>alert('数据库修改失败');history.back(-1);</script>");
                        die( "<script type='text/javascript'>alert('模板修改成功');window.location='admin_template.php?type=$type'</script>");
                    }
		        }
		        else 
		        {
		            die("<script type='text/javascript'>alert('请选择要上传的文件文件');history.back(-1);</script>");
		        }
		    }
?>
<form action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<table width="100%">
  <tr>
	<td class='label' width="150px"><?php echo gettext_r("template").gettext_r("name"); ?>：</td>
    <td><input type="text" name="templatename" value="<?php echo getresultData($template,0,"templatename") ?>" /></td>
  </tr>
  <tr>
	<td class='label'><?php echo gettext_r("template").gettext_r("file"); ?>：</td>
    <td><input type="file" name="templatefile" /></td>
  </tr>
  <tr>
  	<td></td>
	<td><input type="submit" name="submit" value="<?php echo gettext_r("submit"); ?>" /><input type="button" onclick="history.back(-1)" value="<?php echo gettext_r("back"); ?>" /></td>
  </tr>
</table>
</form>
<?php
			break; 
		default:
			echo "<div id='navigation'>".gettext_r("quickLink").":　　";
			echo "<a href=\"admin_template.php?type=$type&action=add\">".gettext_r("add").gettext_r("template")."</a>\n";
			echo "</div>";
			
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
			echo "<tr class='header'>\n";
			echo "<td align='center' width='40'>".gettext_r("serialNumber")."</td>\n";
			echo "<td align='center' width='350'>".gettext_r("template").gettext_r("name")."</td>\n";
			echo "<td align='center' width='200'>".gettext_r("file").gettext_r("name")."</td>\n";
			echo "<td align='center'>".gettext_r("operate")."</td>\n";
			echo "</tr>\n";
			showtemplatelist($type);
			echo "</table>\n";
			echo "<div style='height:5px;'></div>";
	}
?>
</body>
</html>
