// JavaScript Document
function now()
		{
			var now = new Date();
			if($.browser.msie)
				var strNow = now.getYear()+"-";
			else
				var strNow = (now.getYear()+1900)+"-";
			strNow += (now.getMonth()+1)+"-";
			strNow += now.getDate()+" ";
			strNow += now.getHours()+":";
			strNow += now.getMinutes()+":";
			strNow += now.getSeconds()+"    ";
			return strNow;
		}
function autoHeight(obj)
		{
			if($.browser.msie)
			{
				obj.height = Math.max(obj.contentWindow.document.documentElement.scrollHeight,obj.contentWindow.document.body.scrollHeight);
				return;
			}
			//非IE浏览器
			obj.height = obj.contentWindow.document.body.scrollHeight+10;
			//alert(obj.height);
		}
//设置TITLE和location
function setTandL(title,location)
		{
			document.title=title;
			$("#location").html("Your location: "+location);
		}
function showindexarticle()
		{
			$.ajax({
				   url: "frontshowfunction/showindexarticlelist.php?time="+now(),
				   //async: false,
				   error: function(){alert("网络失败");},
				   success: function(Msg){$("#showaero").html(Msg);}
				   });
		}
//初始化主页动画效果
function initflash() 
		{
			$("div.notes").add("div.readmore").hide();
			$("div.notes:first").add("div.readmore:first").show();
			$("div.contenttitle").not($("div.contenttitle:first")).css("padding-bottom","5px");
			$("div.content").mouseover(function(){
					if($(this).children(".notes").is(':visible')) 
					{ 
						return false; 
					}
					$("div.notes:visible").add("div.readmore:visible").slideUp('normal');
					$("div.contenttitle").not($(this).children(".contenttitle")).css("padding-bottom","5px");
					$(this).children(".contenttitle").css("padding-bottom","0px");
					$(this).children(".notes").add($(this).children(".readmore")).slideDown('normal');
					});
		}
function urlget(name)
		{
			var url = window.location;
			return $.query.get(name);
		}

//动态读取文章列表
function showarticlelist(id,page,pagesize)
		{
			//alert("dfa");
			$.ajax({
				   url: "frontshowfunction/showarticlelist.php?time="+now(),
				   async: false,
				   data: {columnid: id, currentpage:page},
				   error: function(){alert("网络失败");},
				   success: function(Msg){
					   if($("#tab"+id).size()>=1)
						   $("#tab"+id).html(Msg);
					   else 
						   $("#tabs").html(Msg);
					   }
				   });
		}
//显示文章列表，但因其和showarticlelist同时调用时有不协调的地方，故此函数暂时废弃
function showpage(id,page,pagesize)
		{
			$.ajax({
				   url: "frontshowfunction/showpage.php?time="+now(),
				   async: false,
				   data: {columnid: id, currentpage:page},
				   error: function(){alert("网络失败");},
				   success: function(Msg){$("#tab"+id).html($("#tab"+id).html()+Msg);}
				   });
		}
//显示文章
function showarticle(id)
		{
			$.ajax({
				   url: "frontshowfunction/showarticle.php?time="+now(),
				   async: false,
				   data: {articleid: id},
				   error: function(){alert("网络失败");},
				   success: function(Msg){$("#maincontent").html(Msg);}
				   });
		}
//在iframe中更新链接
function goto(url)
		{
			parent.$("iframe").attr('src',url);
		}
//回复ajax函数
function quote(id)
		{
			//$("#replyform input").val(id);
			//alert($("#"+id+" ul").html());
			//alert($("#"+id).children().not($("#"+id+" ul")[0]).html());
			//return;
			
			$("#quoteDialog").dialog({
				bgiframe: true,
				autoOpen: false,
				height: 285,
				resizable: false,
				width:400,
				modal: true,
				buttons:{
					'Submit': function() {
							//$("#replyform").submit();
							//ajax提交评论
							var content = $("#commentform textarea").val();
							var aId = urlget("articleid");
							if($.trim(content)=="")
							{
								alert("The comment content is not alowed to set null!");
								return;
							}
							//alert(aId);
							if(aId=="")
							{
								//url参数不正确，缺少articleid参数
								alert("url error!");
								return;
							}
							//alert(aId);
							//alert(content);
							$.ajax({
								   type: "POST",
								   url: "postcomment.php?time="+now(),
								   data: {commentcontent: content, quoteid: id, articleid: aId},
								   error: function(){alert("Failed!");},
								   //刷新窗口
								   success: function(Msg){
										   //alert(Msg);
										   if(Msg=="success")
										   {
											   alert("Comment add success!");
											   //增加新帖
											   var quoteOprationstring = $("#"+id+" ul").html();
											   //alert(quoteOprationstring);
											   var newCommentStr = "<div id='0' class='comment'><div class='author'>\
							   "+($.cookie("username")!=null?$.cookie("username"):"anonymity")+"</div><div class='postTime'>"+now()+"</div>";
											   newCommentStr += "<div class='quotecomment'>"+$("#"+id).html()+"</div>";
											   //alert($("#"+id).html());
											   newCommentStr += content;
											   newCommentStr += "<ul class='operations'>\
													<LI><A class='quote' onClick=\"alert('Please refresh this page!')\" href='#'>回复</A></LI>\
													<LI class=support><A onClick=\"alert('Please refresh this page!')\" href='#'>支持</A>[<SPAN>0</SPAN>]</LI>\
													<LI class=against><A onClick=\"alert('Please refresh this page!')\" href='#'>反对</A>[<SPAN>0</SPAN>]</LI>\
													</ul>\
													</div>\
													<div class='segement'></div>";
											   //alert($("#"+id).children().not($("#"+id+" ul")[0]).html());
											   //newCommentStr = newCommentStr.replace(quoteOprationstring,"");
											   $("#commentmain").prepend(newCommentStr);
											   //alert($("ul.operations:first").size());
											   $("ul.operations:first").remove();
										   }
										   else
										   {
											   //alert(Msg);
											   alert("Comment add failed!");
										   }
										   }
								   });
							//关闭对话框
							$(this).dialog('close');
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				},
				close: function() {}
			});
			$("#quoteDialog").dialog('open');
		}
function submitComment()
		{
			var content = $("#form textarea").val();
			//alert(content);
			//return;
			var aId = urlget("articleid");
			if($.trim(content)=="")
			{
				alert("The comment content is not alowed to set null!");
				return;
			}
			if(aId=="")
			{
				//url参数不正确，缺少articleid参数
				alert("url error!");
				return;
			}
			//alert(aId);
			//alert(content);
			$.ajax({
				   type: "POST",
				   async: false,
				   url: "postcomment.php?time="+now(),
				   data: {commentcontent: content, articleid: aId},
				   error: function(){alert("Failed!");},
				   //刷新窗口
				   success: function(Msg){
						   //alert(Msg);
						   //document.write(Msg);
						   if(Msg=="success")
						   {
							   //添加新评论到当前页
							   var newCommentStr = "<div class='comment'><div class='author'>\
							   "+($.cookie("username")!=null?$.cookie("username"):"anonymity")+"</div><div class='postTime'>"+now()+"</div>\
													<div class='commentcontent'>"+content+"</div><ul class='operations'>\
													<LI><A class='quote' onClick=\"alert('Please refresh this page!')\" href='#'>回复</A></LI>\
													<LI class=support><A onClick=\"alert('Please refresh this page!')\" href='#'>支持</A>[<SPAN>0</SPAN>]</LI>\
													<LI class=against><A onClick=\"alert('Please refresh this page!')\" href='#'>反对</A>[<SPAN>0</SPAN>]</LI>\
													</ul>\
													</div>\
													<div class='segement'></div>";
							   $("#commentmain").prepend(newCommentStr);
							   
							   $("#form textarea").val("");
							   alert("Comment add success!");
						   }
						   else
						   {
							   //alert(Msg);
							   alert("Comment add failed!");
						   }
					   }
				   });
		}
//评论支持代码
function support(commentid)
		{
			$.ajax({
				   url: "frontshowfunction/support.php?time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {commentid: commentid},
				   error: function(){alert("操作失败\n请检查网络");},
				   success: function(Msg){
					    //alert($("#"+commentid+" .support span").text());
						$("#"+commentid+" .support span").text(parseInt($("#"+commentid+" .support span").text())+1);
						$("#"+commentid+" .support a").attr("href","#");
						$("#"+commentid+" .support a").replaceWith("已支持");
					   }
				   });
		}
//评论反对代码
function against(commentid)
		{
			$.ajax({
				   url: "frontshowfunction/against.php?time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {commentid: commentid},
				   error: function(){alert("操作失败\n请检查网络");},
				   success: function(Msg){
					    //alert($("#"+commentid+" .support span").text());
						$("#"+commentid+" .against span").text(parseInt($("#"+commentid+" .against span").text())+1);
						$("#"+commentid+" .against a").replaceWith("已反对");
					   }
				   });
		}
//获得调查代码
function showvote(id)
		{
			$.ajax({
				   url: "frontshowfunction/getvote.php?time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {voteid: id},
				   error: function(){alert("获得代码失败\n请检查网络");},
				   success: function(Msg){
					   //alert(Msg);
					   document.write(Msg);
					   }
				   });
		}
//登录相关函数
function showlogin()
		{
			document.write("<div id='login' title='Login' style='display:none;'><form id='loginform' name='loginform' method='get' action='login.php'><div style='font-size:15px;'><br/><br/>Username: <input style='height:20px;' type='text' name='username'/><br/><br/><br/>Password: <input type='password' name='password' style='height:20px;'/></div></form></div>");
			if($.cookie("username")!=null&&$.cookie("username")!="")
			{
				document.write("<a id='loginlink' href='#'>Welcome,"+$.cookie("username")+"</a> <a id='logoutorregister' href='#' onclick='logout()'>Logout</a>");
			}
			else
			{
				document.write("<a id='loginlink' href='#' onclick='showloginform()'>Login</a> <a id='logoutorregister' href='register.php'>Register</a>");
			}
		}
function showloginform()
        {
			$("#login").dialog({
				bgiframe: true,
				autoOpen: false,
				height: 240,
				resizable: false,
				width:350,
				modal: true,
				buttons:{
					'Login': function() {
							//$("#replyform").submit();
							//ajax提交评论
							var username = $("#loginform input[name='username']").val();
							var password = $("#loginform input[name='password']").val();
							if($.trim(username)=="")
							{
								return;
							}
							if(password=="")
							{
								return;
							}
							//alert(aId);
							//alert(content);
							$.ajax({
								   type: "GET",
								   url: "login.php?time="+now(),
								   data: {username: username, password: password},
								   error: function(){alert("Failed!");},
								   //刷新窗口
								   success: function(Msg){
										   //alert(Msg);
										   if(Msg=="logined")
										   {
											   $("#loginlink").attr("onclick","");
											   $("#loginlink").text("welcome,"+$.cookie("username"));
											   $("#logoutorregister").replaceWith("<a id='logoutorregister' href='#' onclick='logout()'>Logout</a>");
										   }
										   else if(Msg=="locked")
										   {
											   alert("You have been locked by the Web Master!");
										   }
										   else
										   {
											   alert("Login failed!");
										   }
										   }
								   });
							//关闭对话框
							$(this).dialog('close');
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				},
				close: function() {}
			});
			$("#login").dialog('open');
			$("#loginform input[name='username']").focus();
			$("#login").keypress(function(e){
      		  if(e.keyCode == 13)
			  {
				   var username = $("#loginform input[name='username']").val();
				   var password = $("#loginform input[name='password']").val();
				   if($.trim(username)=="")
					{
						return;
					}
					if(password=="")
					{
						return;
					}
							//alert(aId);
							//alert(content);
					$.ajax({
						   type: "GET",
						   url: "login.php?time="+now(),
						   data: {username: username, password: password},
						   error: function(){alert("Failed!");},
						   //刷新窗口
						   success: function(Msg){
						   //alert(Msg);
						   if(Msg=="logined")
						   {
							   $("#loginlink").attr("onclick","");
							   $("#loginlink").text("welcome,"+$.cookie("username"));
							   $("#logoutorregister").replaceWith("<a id='logoutorregister' href='#' onclick='logout()'>Logout</a>");
						   }
						   else if(Msg=="locked")
						   {
							   alert("You have been locked by the Web Master!");
						   }
						   else
						   {
							   alert("Login failed!");
						   }
						   }
					  });
				   $("#login").dialog('close');
        	  }
    		})
		}
//清除cookie退出
function logout()
		{
			$.cookie("username",null);
			$("#logoutorregister").replaceWith("<a id='logoutorregister' href='register.php'>Register</a>");
			$("#loginlink").replaceWith("<a href='#' id='loginlink' onclick='showloginform()'>Login</a>");
		}









