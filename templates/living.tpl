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
                <table width="95%" border="0" cellspacing="5" cellpadding="0" style="margin-top:15px; margin-bottom:15px;">
           		  <tr>
                    <td id="la_imga"><img src="images/living_pic01bank.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=173" target="_blank">Banks</a></td>
                    <td id="la_imga"><img src="images/living_pic02catering.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=174" target="_blank">Catering</a></td>
                  </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic03map.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="gmap.html" target="_blank">Campus Map</a></td>
                    <td id="la_imga"><img src="images/living_pic04citymap.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="gmap.html" target="_blank">City Map</a></td>
             </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic05bar.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=175" target="_blank">Entertainment</a></td>
                    <td id="la_imga"><img src="images/living_pic06festival.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=176" target="_blank">Festival</a></td>
                  </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic07apartnent.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=177" target="_blank">Foreign Teeachr Apartment</a></td>
                    <td id="la_imga"><img src="images/living_pic08apartnent1.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=178" target="_blank">Foreign Student Apartment</a></td>
                  </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic09hospital.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=179" target="_blank">Hospital</a></td>
                    <td id="la_imga"><img src="images/living_pic10hotel.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=180" target="_blank">Hotels</a></td>
                  </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic11inet.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=181" target="_blank">Internet Service</a></td>
                    <td id="la_imga"><img src="images/living_pic12post.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=182" target="_blank">Posts Services</a></td>
             </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic13shopping.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=183" target="_blank">Shopping</a></td>
                    <td id="la_imga"><img src="images/living_pic14sport.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=184" target="_blank">Recreation Center</a></td>
             </tr>
                  <tr>
                    <td id="la_line" colspan="2"></td>
                  </tr>
                  <tr>
                    <td id="la_imga"><img src="images/living_pic15bus.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=185" target="_blank">Transportation</a></td>
                    <td id="la_imga"><img src="images/living_pic16servise.jpg">&nbsp;&nbsp;&nbsp;&nbsp;<a href="showarticle.php?articleid=186" target="_blank">Miscellaneous Service</a></td>
             </tr>
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