<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>【#htmltitle】</title>
<script language="javascript" src="js/AJAXFrame.js"></script>
<script language="javascript" src="js/EventFrame.js"></script>
<script language="javascript" src="js/lists.js"></script>
<script language="javascript" src="js/Search.js"></script>
<link href="css/public.css" rel="stylesheet" type="text/css" />
<link href="css/column.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <div id="top"></div>
  
  <hr width="100%"/>
  <div id="main">
  	<div id="main_left">
      <ul>
      【#MY_nav】
      </ul>
    </div>
    <div id="main_right">
      <div id="main_right_top">
         <div id="currentPosition">您的位置：【#path】</div>
         <div id="search"> 
         	<form action="showsearchresult.php" method="get"><input id="searchbox" type="text" size="19" name="title"  value="请输入检索内容" onfocus="javascript:this.select()" /><img src="images/icon_search.png" id="searchBtn"/></form>
         </div>
      </div>
      <div id="main_right_main">
            <div id="content">
            	<div id="title"><img src="images/icon2.png" /><span>【#columnname】</span></div>
                <div id="lists">
				    <table>
						【articlelist(columnid,10,45,1,0,0,0,0)】
                    	<tr>
                            <td width="10"><img src="images/triangle.png" /></td>
                            <td width="84%"><a href="showarticle.php?articleid=【#id】">【#title】</a></td>
                            <td>【#time】</td>
                    	</tr>
                     	【/articlelist】
                     </table>
                 </div>
                 <div id="pages">【#showpage】</div>
            </div>
            <div id="news">
            	<div id="tzgg">
              		<div class="title"><span>通知公告</span></div>
              		<table>
                    【articlelist(6,3,10,0,0,0,0,0)】
               		<tr>
               			<td width="7%"><img src="images/icon.png" /></td>
               			<td><a href="showarticle.php?articleid=【#id】">[【#time】]【#notes】</a></td>
               		</tr>
               		【/articlelist】
              		</table>
              	</div>
            	<div id="lxfs">
            	<div class="title"><span>联系方式</span></div>
             	<table>
                	<tr><td width="25%">电话：</td><td>0451-86154257</td></tr>
                	<tr><td width="25%">邮箱：</td><td>xuediao@hrbeu.edu.cn</td></tr>
            	</table>
            	</div>
            </div>
            <div style="clear:both; height:1px; overflow:hidden;"></div>
         </div>
    </div>
	<div style="clear:both; height:1px;"></div>
 </div>
 <div id="bottom">【#copyright】</div>
</body>
</html>