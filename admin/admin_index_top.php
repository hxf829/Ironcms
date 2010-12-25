<?php
session_start();
?>
<?php
	include_once("../conn.php");
	include_once('../library/basefunction.php');
	include_once "../lang/envinit.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>top</title>
	<link href="css/top.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/adminmainFunction.js"></script>
    <script type="text/javascript">
        $(document).ready(
		function() 
			{ 
				showtime();
			}
		);
    </script>
    
    <script language="JavaScript"> 
	var NS4 = (document.layers); 
	var IE4 = (document.all); 
	var win = window; 
	var n = 0; 
	function findIt() { 
		if (IEsearch.value != "") 
		findInPage(IEsearch.value); 
	} 
	function findInPage(str) { 
	var txt, i, found; 
	if (str == "") 
	return false; 
		if (NS4) { 
			if (!win.find(str)) 
			while(win.find(str, false, true)) 
			n++; 
			else 
			n++;
			if (n == 0) 
			alert("<?php echo gettext_r("haveNotSearchResult"); ?>"); 
		}
		if (IE4) { 
//			txt = win.document.body.createTextRange();
			txt = parent.main.document.body.createTextRange();
			for (i = 0; i <= n && (found = txt.findText(str)) != false; i++) { 
				txt.moveStart("character", 1); 
				txt.moveEnd("textedit"); 
				}
			if (found) { 
				txt.moveStart("character", -1); 
				txt.findText(str); 
				txt.select(); 
				txt.scrollIntoView(); 
				n++; 
				} 
			else { 
				if (n > 0) { 
				n = 0; 
				findInPage(str); 
				} 
					else 
					alert("<?php echo gettext_r("haveNotSearchResult"); ?>"); 
				} 
		} 
	return false; 
	}
	</script>
</head>

<body>
<!--第一条背景-->
<div id="topbg2" style="overflow:hidden">
  <div id="topbg1"></div>
  <div id="welcome"><img src="images/index_top_arrow1.png" />&nbsp;<?php echo getlogininfo("adminname");?>&nbsp;&nbsp;<?php echo gettext_r("welcomeToSystem");?>&nbsp;&nbsp;<?php echo gettext_r("youCan");?>【<a target="main" href="changepassword.php"><?php echo gettext_r("change").gettext_r("password");?></a>】【<a target="_parent" href="logout.php"><?php echo gettext_r("logOut");?></a>】</div>
</div>
<!--第一条背景结束-->

<!--第二条背景-->
<div id="topbg4">
  <div id="topbg3"></div>
  <div style="float:right">
    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td id="search">
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="IEsearch" type="text" value="<?php echo gettext_r("searchThisPage");?>" size="35" maxlength="50" onfocus="javascript:this.select()" 
                   style="height:16px; font-family:'微软雅黑','宋体'; font-size:12px; color:#666666;" onkeydown="if(event.keyCode==13){javascript:findIt()}"/>
              </td>
              <td width="5px"></td>
              <td><input name="search" type="button" value="<?php echo gettext_r("search");?>" style="height:25px"/ onClick="javascript:findIt();"></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td id="time" valign="middle"><span></span></td>
      </tr>
    </table>
  </div>
</div>
<!--第二条背结束景-->
</body>
</html>