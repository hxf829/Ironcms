<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>清理图片</title>
<link rel="stylesheet" type="text/css" href="css/functionstyle.css">
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/adminmainFunction.js"></script>

</head>
<body style="padding:20px;" bgcolor="#f3f9ff">
<?php
	include "../conn.php";
	include_once "../library/basefunction.php";
	include_once "../lang/envinit.php";
	function fileextension($file_name)   
	{   
		$extend = pathinfo($file_name);   
		$extend = strtolower($extend["extension"]);   
		return $extend;   
	}  
	function checkimg($imgdir, $index=0)
	{
		$dir = opendir($imgdir);
		if ($dir == NULL)
			return;
		while($file = readdir($dir))
		{
			if ($file != "." and $file != "..") 
			{
				//echo $imgdir."/".$file."<br>";
				$path = $imgdir."/".$file;
				if (is_dir($path))
					checkimg($path,$index+1);
				else
				{
					$filename = basename($path);
					$ifused = getresultNumrows(getresult("select * from I_article where contents like '%".$filename."%'"));
					if ($ifused <= 0)
					{
						echo "删除：".$path."<br>";
						unlink($path);
					}
				}
			}
		}
		closedir($dir);
		//呵呵，这个函数只能删除空文件夹，有文件的文件夹会失败
		if ($index != 0)
		{
			if(rmdir($imgdir))
			{
				echo "删除".$imgdir."<br>";
			}
		}
	}
	echo "<table width='100%' border='0' cellpadding='0' cellspacing='1' class='function'>\n";
	echo "<tr class='header'>\n";
	echo "<td align='center'>".gettext_r("processing")."</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td align='left'>";
	checkimg(getroot()."/userfiles");
	echo "清理完毕";
	echo "</td>\n";
	echo "</tr>\n";
?>
</div>
</body>
</html>