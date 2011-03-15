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
<link rel="stylesheet" type="text/css" href="css/channel.css">
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

/*main部分CSS开始*/
#main_bg{
width:740px;
background:url(images/index_main_bg.png) repeat-y;
}
#main_column{
width:740px;
background:url(images/index_main_top_bg.jpg) top no-repeat;
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
        </td>
        
        <td id="main_bg" valign="top">
        	<div id="main_column">
                <table width="100%" border="0" cellspacing="10" cellpadding="5" style="margin-top:4px; margin-bottom:4px;">
                  <tr>
                    <td id="us_title">Our Mission</td>
                  </tr>
                  <tr>
                    <td id="us_content">Harbin Engineering University is defining her distinctive position in the nation's development strategy by specializing in shipping industry, ocean exploration and nuclear application. By also leading a series of reforms in teaching, scientific research and information management systems, Harbin Engineering University is expanding her role as China's premier comprehensive international university now and into the 21st century.</td>
                 </tr>
                  <tr>
                    <td id="us_pic"><img src="images/university_pic01.jpg"/>&nbsp;&nbsp;<img src="images/university_pic02.jpg"/>&nbsp;&nbsp;<img src="images/university_pic03.jpg"/></td>
                 </tr>
                  <tr>
                    <td id="us_a">| <a href="showarticle.php?articleid=43">Our Mission</a> | <a href="showarticle.php?articleid=44">Message from the President</a> | <a href="showarticle.php?articleid=45">Brief Introduction</a> | <a href="showarticle.php?articleid=46">Awards and Honors</a> | <a href="showarticle.php?articleid=47">Former Officers</a> |<br />
    | <a href="showarticle.php?articleid=48">Inscription by State Leaders</a> | <a href="showarticle.php?articleid=49">University Culture</a> | <a href="showarticle.php?articleid=50">Download the Prospectus in PDF Format</a>  | <a href="showarticle.php?articleid=51">Key Figures</a> |</td>
                 </tr>
                  <tr>
                    <td id="us_a"><a href="showarticle.php?articleid=393" target="_blank">See the Introduction Video of HEU</a></td>
                 </tr>
                  <tr>
                    <a href="showarticle.php?articleid=52"><td id="us_title" style="cursor:pointer">Our History</td></a>              </tr>
                  <tr>
                    <td id="us_title">Information about the City of Harbin</td>
                  </tr>
                  <tr>
                    <td id="us_a">| <a href="showarticle.php?articleid=53">Brief</a> | <a href="showarticle.php?articleid=54">Local features</a> | <a href="showarticle.php?articleid=55">Climate in Harbin</a> | <a href="showarticle.php?articleid=56">Attractions and sightseeing</a> | <a href="showarticle.php?articleid=57">Entertainment</a> | <a href="showarticle.php?articleid=58">Transportation</a> | <a href="#">Map</a> | <a href="living.html">Living on campus</a> | <a href="#">Web links</a> |</td>
                 </tr>
                  <tr>
                    <a href="showarticle.php?articleid=58"><td id="us_title" style="cursor:pointer">How to Reach us/Travel to Campus</td></a>              </tr>
                  <tr>
                    <a href="#"><td id="us_title" style="cursor:pointer">Campus Maps</td></a>             </tr>
               </table>
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