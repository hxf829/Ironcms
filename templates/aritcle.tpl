<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>【#htmltitle】</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/front.js"></script>
<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.7.1.custom.css">
<style type="text/css">
<!--
body{
margin:0px; padding:0px; background:#666666;
font-size:65%;
}
div{
margin:0px; padding:0px; overflow:hidden;
}
img{
border:0px;
}
.navigatetext{
width:119px;
height:14px;
}
.navigatebottom{
width:58px;
height:21px;
font-family:Tahoma, Verdana;
color:#4a4949;
font-size:10px;
}
#top{
width:100%;
height:101px;
background:url(images/index_top_bg.png) repeat-x;
text-align:center;
}
#top_logo_left{
width:20px;
height:101px;
background:url(images/index_logo_left.png) no-repeat;
}
#top_logo{
width:220px;
height:101px;
}
#top_pic{
width:760px;
height:74px;
background:url(images/index_top_pic.jpg) no-repeat;
text-align:right;
float:left;
clear:right;
}
#top_pic span{
font-family:Tahoma, Verdana;
font-size:12px;
color:#FFFFFF;
line-height:20px;
text-align:right;
padding-right:20px;
}
#top_pic span a{
color:#FFFFFF;
text-decoration:none;
}
#top_pic span a:hover{
color:#FFFFFF;
text-decoration:underline;
}
#top_search{
width:760px;
height:27px;
background:url(images/index_top_search.jpg) no-repeat;
float:left;
}
#top_language{
padding-left:20px;
text-align:left;
font-family:Tahoma, Verdana;
color:#eeeeee;
font-size:11px;
line-height:25px;
float:left;
}
#top_language a{
color:#eeeeee;
text-decoration:none;
}
#top_language a:hover{
text-decoration:underline;
}
#top_search{
text-align:right;
float:right;
}

#location{
background-color:#f77f00;
height:25px;
}
#location_bg{
width:1000px;
background:url(images/index_top_location.jpg) no-repeat;
text-align:left;
}
#location_text{
text-align:left;
padding-left:45px;
font-family:Tahoma, Verdana;
color:#FFFFFF;
font-size:12px;
line-height:23px;
}
#location_text a{
color:#FFFFFF;
text-decoration:none;
}
#location_text a:hover{
color:#FFFFFF;
text-decoration:underline;
}
#main_fg{
width:100%;
background:url(images/index_fg.png) repeat-x #ffffff;
}
#nav{
width:220px;
height:430px;
}
#vote{
width:220px;
padding-top:5px;
text-align:left;
}
#votetitle{
font-family:"微软雅黑", Arial, Tahoma;
font-size:14px;
font-weight:bold;
color:#001f4a;
text-align:left;
padding:10px 5px 10px 14px;
}
.voteoption{
font-family:"微软雅黑", Arial, Tahoma;
font-size:13px;
color:#001f4a;
text-align:left;
padding-left:14px;
height:25px;
}
#votebutton{
width:60px;
height:24px;
font-family:"微软雅黑";
font-size:12px;
margin-left:20px;
}

/*main部分CSS开始*/
#main_bg{
width:740px;
background:url(images/index_main_bg.png) repeat-y;
}
#main_article{
width:740px;
background:url(images/index_main_top_bg.jpg) top no-repeat;
}
#main_title{
text-align:center;
font-family:Arial;
color:#d05300;
font-size:20px;
word-wrap: break-word;
word-break: normal;
padding:15px 10px 5px 10px;
}
#main_info{
margin:10px;
padding:5px;
border:#8AC2F4 1px solid;
background-color:#ffffff;
font-family:Tahoma, Verdana;
font-size:12px;
line-height:20px;
text-align:center;
color:#0000CC;
}
#main_text{
text-align:justify;
font-family:Tahoma, Verdana;
font-size:13px;
line-height:20px;
padding:0px 20px 0px 20px;
}
#main_editor{
text-align:right;
font-family:Tahoma, Verdana;
font-size:13px;
padding-right:20px;
}
#main_prenext{
margin:10px;
padding:7px 10px 7px 10px;
border:#8AC2F4 1px solid;
background-color:#ffffff;
font-family:Tahoma, Verdana;
font-size:12px;
line-height:20px;
text-align:left;
color:#36455b;
word-break:keep-all;
}
#main_prenext a{
color:#36455b;
text-decoration:none;
}
#main_prenext a:hover{
text-decoration:underline;
}
/*main部分CSS结束*/

#main_shadow{
width:20px;
background:url(images/index_fg_shadow.png) repeat-y left;
}
#bottom_line{
background-color:#f77f00;
height:3px;
}
#bottom_bg{
background-color:#666666;
padding-top:15px;
padding-bottom:20px;
text-align:center;
font-family:Tahoma, Verdana;
color:#dddddd;
font-size:12px;
}
-->
</style>
</head>

<body>
<div id="top">
<table width="1000px" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td id="top_logo_left"></td>
    <td id="top_logo"><a href="index.php"><img src="images/index_logo.png"/></a></td>
    <td>
      <div id="top_pic"><span><script type="text/javascript">showlogin();</script></span></div>
      <div id="top_search">
        <span id="top_language">Language:&nbsp;&nbsp;<strong>English</strong>&nbsp;&nbsp;<a href="http://www.hrbeu.edu.cn/" target="_blank">Chinese</a>&nbsp;&nbsp;<a href="http://rus.hrbeu.edu.cn/" target="_blank">Russian</a></span>
        <span id="top_serach">
            <form action="showsresult.php" id="cse-search-box">
              <div style="padding-top:2px;">
                <input type="hidden" name="cx" value="018438213955608383295:1zktv9rmz4i" />
                <input type="hidden" name="cof" value="FORID:11" />
                <input type="hidden" name="ie" value="UTF-8" />
                <input type="text" name="q"/>
                <input type="submit" name="sa" value="Search" / style="height:23px;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              </div>
            </form>            
            <script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&lang=en"></script>
        </span>
      </div>
    </td>
  </tr>
</table>
</div>

<div id="location" align="center">
	<div id="location_bg" style="width:1000px; text-align:left">
		<div id="location_text">Your location: 【#path】</div>
    </div>
</div>

<div id="main_fg" align="center">
	<table width="1000px" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20px"></td>
        <td width="220px" valign="top" bgcolor="#e8eef5">
        	<div id="nav">【#MY_nav】</div>
            <script type='text/javascript'>showvote(1);</script>
        </td>
        
        <td id="main_bg" valign="top">
        	<div id="main_article">
                <div id="main_title">【#articletitle】</div>
                <div id="main_info">Author：【#author】【#source】&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date：【#date】&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hit：【#hits】</div>
                <div id="main_text">【#articlecontent】</div>
                <div id="main_prenext"><strong>Preced Article：</strong>【#pre】<br /><strong>&nbsp;&nbsp;&nbsp;Next Article：</strong>【#next】</div>
                <div id="main_comments" style="text-align:right; padding:0px 15px 15px 0px; font-size:14px; font-weight:bold"><a style="color:#A80000" href="showcomment.php?articleid=【#articleid】&pagesize=10" target="_blank">Show Comments</a></div>
            </div>
        </td>
        
        <td id="main_shadow"></td>
      </tr>
    </table>
</div>
<div id="bottom_line"></div>
<div id="bottom_bg">【#copyright】</div>
</body>
</html>