//检测管理员是否登录
var currentUrl = ""+window.location;
var currentWebFile = currentUrl.substring(currentUrl.lastIndexOf("/")+1,currentUrl.length);
//alert(currentWebFile);
if(currentWebFile != "login.php")
{
	//alert("sdfa");
	checklogin();
}

function checklogin()
		{
			$.ajax({
				   url: "checklogin.php?time="+now(),
				   async: false,
				   error: function(){alert("网络连接错误");},
				   success: function(Msg){
					   //alert(Msg);
					   //alert(Msg+"==notlogin="+(Msg=="notlogin"));
					   if(Msg=="notlogin")
					   {
						   window.location.href="login.php";
					   }
					   }
				   });
		}
function initMenu()
        {
            $('#function_menu div div').hide();
            $('#function_menu div span').click
            (
                function()
                {
                    $(this).next().slideToggle('1000');
                }
            );
        }
function showtime()
		{
			$("#time span").html(now());
			setTimeout("showtime()", 1000);
		}
function now()
		{
			var now = new Date();
			if($.browser.msie)
				var strNow = now.getYear()+"-";
			else
				var strNow = (now.getYear()+1900)+"-";
			strNow += (now.getMonth()+1)+"-";
			strNow += now.getDate()+"- ";
			strNow += now.getHours()+":";
			strNow += now.getMinutes()+":";
			strNow += now.getSeconds()+"    ";
			return strNow;
		}
function autoHeight(obj)
		{
			if($.browser.msie)
			{
				obj.height = obj.contentWindow.document.documentElement.scrollHeight;
				return;
			}
			//非IE浏览器
			obj.height = obj.contentWindow.document.body.scrollHeight+10;
		}
function liststyle_mousechange()
        {
            $("tr.list").mouseover
            (
                function()
                {
                    $(this)[0].className = "list_onmousemove";
					//alert("dsfa");
                }
            );
			
			$("tr.list").mouseout
            (
                function()
                {
                    $(this)[0].className = "list";
					//alert("dsfa");
                }
            );
        }
function jump(url,action,id)
		{
			if(url=="admin_column.php")
				window.location = url+"?action="+action+"&columnid="+id+"&url="+window.location;
			else if(url=="admin_article.php")
				window.location = url+"?action="+action+"&articleid="+id+"&url="+window.location;			
			else if(url=="admin_admin.php")
				window.location = url+"?action="+action+"&adminid="+id+"&url="+window.location;	
			else if(url=="admin_user.php")
			{
				//alert("fasdf");
				window.location = url+"?action="+action+"&userid="+id+"&url="+window.location;
			}
			else if(url=="admin_comment.php")
			{
				window.location = url+"?action="+action+"&commentid="+id+"&url="+window.location;
				//document.write(url+"?action="+action+"&userid="+id+"&"+key+"="+value+"&url="+window.location);
			}
			else if(url=="admin_template.php")
			{
				window.location = url+"?action="+action+"&id="+id+"&url="+window.location;			
			}
			else if(url=="admin_mylabel.php")
			{
				window.location = url+"?action="+action+"&id="+id+"&url="+window.location;			
			}
		}
function jump(url,action,id,key,value)
		{
			if(url=="admin_column.php")
				window.location = url+"?action="+action+"&columnid="+id+"&url="+window.location;
			else if(url=="admin_article.php")
				window.location = url+"?action="+action+"&articleid="+id+"&"+key+"="+value+"&url="+window.location;			
			else if(url=="admin_admin.php")
				window.location = url+"?action="+action+"&adminid="+id+"&url="+window.location;	
			else if(url=="admin_user.php")
			{
				window.location = url+"?action="+action+"&userid="+id+"&"+key+"="+value+"&url="+window.location;
				//document.write(url+"?action="+action+"&userid="+id+"&"+key+"="+value+"&url="+window.location);
			}
			else if(url=="admin_vote.php")
			{
				window.location = url+"?action="+action+"&voteid="+id+"&"+key+"="+value+"&url="+window.location;
				//document.write(url+"?action="+action+"&userid="+id+"&"+key+"="+value+"&url="+window.location);
			}
			else if(url=="admin_comment.php")
			{
				window.location = url+"?action="+action+"&commentid="+id+"&"+key+"="+value+"&url="+window.location;
				//document.write(url+"?action="+action+"&userid="+id+"&"+key+"="+value+"&url="+window.location);
			}
			else if(url=="admin_template.php")
			{
				window.location = url+"?action="+action+"&id="+id+"&"+key+"="+value+"&url="+window.location;
				//document.write(url+"?action="+action+"&userid="+id+"&"+key+"="+value+"&url="+window.location);
			}
			else if(url=="admin_mylabel.php")
			{
				window.location = url+"?action="+action+"&id="+id+"&"+key+"="+value+"&url="+window.location;
			}
			else if(url=="admin_field.php")
			{
				window.location = url+"?action="+action+"&fieldid="+id+"&"+key+"="+value+"&url="+window.location;
			}
		}
function column_form_check()
		{
			if($.trim($("input[name='columnname']").val()) == "")
				{
					alert("英文名不能为空");
					$("input[name='columnname']").focus();
					return false;
				}
			if($.trim($("input[name='keywords']").val()) == "")
				{
					alert("关键字不能为空");
					$("input[name='keywords']").focus();
					return false;
				}
			return true;
		}
function article_form_check()
		{
			
			if($("select[name='columnid']").val()==-1)
				{
					alert("没有选定栏目");
					return false;
				}
			if($.trim($("input[name='title']").val()) == "")
				{
					alert("文章题目不能为空");
					$("input[name='title']").focus();
					return false;
				}
			if($.trim($("input[name='author']").val()) == "")
				{
					//alert("Enlish name could not be NULL");
					alert("作者不能为空");
					$("input[name='author']").focus();
					return false;
				}
			if($.trim($("input[name='source']").val()) == "")
				{
					alert("来源不能为空");
					$("input[name='source']").focus();
					return false;
				}
			//if($.trim($("textarea").val()) == "")
				//{
					//alert("简介不能为空");
				//	$("textarea").focus();
				//	return false;
				//}
			//此下判断为下下策，若有高人有得更好的代码，请联系hxf829@163.com
			if($("iframe").contents().find("iframe").contents().find("body").html()=="<p><br></p>")
				{
					alert("正文不能为空");
					return false;
				}
			//$(":submit").attr("disabled","disabled");
			return true;
		}
function vote_form_check()
		{
			if($.trim($("input[name='title']").val()) == "")
			{
				alert("调查题目不能为空");
				$("input[name='title']").focus();
				return false;
			}
			return true;
		}
function chpassword_form_check()
		{
			if($.trim($("input[name='oldpassword']").val()) == "")
			{
				alert("旧密码不能为空");
				$("input[name='oldpassword']").focus();
				return false;
			}
			if($.trim($("input[name='newpwd']").val()) == "")
			{
				alert("新密码不能为空");
				$("input[name='newpwd']").focus();
				return false;
			}
			if($.trim($("input[name='newpwd']").val()).length < 6 )
			{
				alert("新密码不能小于六个字符");
				$("input[name='newpwd']").focus();
				return false;
			}
			if($.trim($("input[name='newpwd']").val()) == $.trim($("input[name='newpwd1']").val()))
			{
				alert("两次密码输入不同");
				$("input[name='newpwd']").focus();
				return false;
			}
		}
//faceditor图片上传后续处理
function uploadCompleted(fileUrl, fileName)
		{
			//添加下拉列表框的选项
			$("#piclist").append("<option selected value=\""+fileUrl+"\">"+fileName+"</option>"); 
			//更改图片路径填写框的值
			$("#picurl").val(fileUrl);
			//更改图片预览的src属性
			$("#preview").attr("src",fileUrl); 
		}
function s(fileUrl)
		{
			$("#test").html(fileUrl);
		}
//一下两个函数功能相等，但一个可以连续调用，另一个必须单独调用
function passarticle(articleid,ifpass)
		{
			$.ajax({
				   url: "admin_article.php?action=pass&time="+now(),
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {articleid: articleid, ifpass: ifpass},
				   error: function(){alert("操作失败");},
				   success: function(Msg){window.location=window.location;}
				   });
		}
//审核文章
function passarticleall(articleid,ifpass)
		{
			$.ajax({
				   url: "admin_article.php?action=pass&time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {articleid: articleid, ifpass: ifpass},
				   error: function(){alert("对编号为"+columnid+"的文章操作失败");}
				   });
		}

function passall(ifpass)
		{
			if($("input:checked[name='list']").size()<1)
			{
				alert('没有选中一个项目');
				return false;
			}
			$("input:checked[name='list']").map(function()
											   {
												   //alert($(this).val());
												   passarticleall($(this).val(), ifpass);
												}); 
			//如果浏览器的javascript运行在此处有错误，可调换以下两行代码的顺序
			window.location=window.location;
			alert("操作成功");
		}
//审核评论
function passcommentall(commentid,ifpass)
{
	$.ajax({
		   url: "admin_comment.php?action=pass&time="+now(),
		   async: false,
		   data: {commentid: commentid, ifpass: ifpass},
		   error: function(){alert("对编号为"+commentid+"的评论操作失败");}
		   });
}
function passcomment(ifpass)
{
	if($("input:checked[name='list']").size()<1)
	{
		alert('没有选中一个项目');
		return false;
	}
	$("input:checked[name='list']").map(function()
									   {
										   //alert($(this).val());
										   passcommentall($(this).val(), ifpass);
										}); 
	//如果浏览器的javascript运行在此处有错误，可调换以下两行代码的顺序
	window.location=window.location;
	alert("操作成功");
}
function deletearticleall(url,articleid)
		{
			$.ajax({
				   url: url+"?action=delete&time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {articleid: articleid},
				   error: function(){alert("对编号为"+columnid+"的文章操作失败");}
				   });
		}
function deleteall(url)
		{
			if($("input:checked[name='list']").size()<1)
			{
				//alert($("input:checked[name='list']").size());
				alert('没有选中一个项目');
				return false;
			}
			
			$("input:checked[name='list']").map(function()
											   {
												   //alert($(this).val());
												   if(url=="admin_article.php")
												   		deletearticleall(url, $(this).val());
												   else if(url=="admin_admin.php")
										   				deleteadminall(url, $(this).val());
												   else if(url=="admin_vote.php")
										   				deletevoteall(url, $(this).val());
												   else if(url=="admin_comment.php")
										   				deletecommentall(url, $(this).val());
												   else if(url=="admin_log.php")
										   				deletelogall(url, $(this).val());
												}); 
			//如果浏览器的javascript运行在此处有错误，可调换以下两行代码的顺序
			window.location=window.location;
			alert("操作成功");
		}
function deleteadminall(url,adminid)
		{
			$.ajax({
				   url: url+"?action=delete&time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {adminid: adminid},
				   error: function(){alert("对编号为"+adminid+"的管理员操作失败");}
				   });
		}
//删除调查 
function deletevoteall(url,voteid)
		{
			$.ajax({
				   url: url+"?action=delete&time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {voteid: voteid},
				   error: function(){alert("对编号为"+voteid+"的调查操作失败");}
				   });
		}
//删除评论
function deletecommentall(url,commentid)
		{
			$.ajax({
				   url: url+"?action=delete&time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {commentid: commentid},
				   error: function(){alert("对编号为"+commentid+"的评论操作失败");}
				   });
		}
//删除日志
function deletelogall(url,id)
		{
			$.ajax({
				   url: url+"?action=delete&time="+now(),
				   async: false,
				   //data: "columnid="+columnid+"&ifpass="+ifpass,
				   data: {id: id},
				   error: function(){alert("对编号为"+commentid+"的日志操作失败");}
				   });
		}
function checkall()
		{
			if($("#checkall").attr("checked") == true)
				$("input:not(:disabled)[name='list']").attr("checked", true); 
			else
				$("input[name='list']").attr("checked", false); 
		}
function checkadminname(name,obj)
		{
			if($.trim(name)=="")
			{
				alert("管理员名为空");
				return;
			}
			$(obj).html("<span style='color:#cccccc'>检测管理员名</span>");
			$.ajax({
				   url: "checkadminname.php?time="+now(),
				   data: {adminname: $.trim(name)},
				   error: function(){alert("检测失败");},
				   success: function(Msg){if(Msg=="exist")alert("此管理员名已经存在");else if(Msg=="not")alert("此管理员名可以使用");$(obj).html("检测管理员名");}
				   });
		}
function admin_form_check()
		{
			if($.trim($("input[name='adminname']").val()) == "")
				{
					alert("管理员名不能为空");
					$("input[name='adminname']").focus();
					return false;
				}
			if($.trim($("input[name='adminname']").val()).length<4)
				{
					alert("管理员名不能小于4个字符");
					$("input[name='adminname']").focus();
					return false;
				}
			if($.trim($("input[name='pwd']").val()) == "")
				{
					alert("密码不能为空");
					$("input[name='pwd']").focus();
					return false;
				}
			if($.trim($("input[name='pwd']").val()).length<8)
				{
					alert("密码不能小于8个字符");
					$("input[name='pwd']").focus();
					return false;
				}
			if($.trim($("input[name='pwd']").val()) != $.trim($("input[name='pwd1']").val()))
				{
					alert("两次密码输入不同");
					$("input[name='pwd']").val("");
					$("input[name='pwd1']").val("");
					$("input[name='pwd']").focus();
					return false;
				}
			//return false;
			return true;
		}
function changeconfirmimage()
		{
			$("#confirmimage").attr("src","../library/confirmimage.php?time="+now());
			$("#confirmstr").focus();
		}
//显示权限时，复选框与单选按钮互锁
function lockeachother() 
		{
			$("input[type='checkbox'][name='columnid']").bind(
					'click',
					function()
						{
							//alert($(this).attr('checked'));
							if($(this).attr('checked')!=true)
							{
								$("input[name='"+$(this).val()+"']").removeAttr('checked');
								$("input[name='"+$(this).val()+"']").attr('disabled','true');
							}
							else
							{
								$("input[name='"+$(this).val()+"']").removeAttr('disabled');
								$("input[name='"+$(this).val()+"']:first").attr('checked','true');
							}
						}
					);
			$("input[type='checkbox'][name='columnid']").each(function(){
				if($(this).attr('checked')!=true)
				{
					$("input[name='"+$(this).val()+"']").attr('disabled','true');
				}
			});
		}
function voteoptioncountchange()
		{
			$("select").change(
				function() 
				{
					var i=0;
					//alert($(this).val());
					for(i=1;i<1+parseInt($(this).val());i++)
					{
						$("#list"+i).show();
					}
					for(i=1+parseInt($(this).val());i<7;i++)
					{
						$("#list"+i).hide();
					}
				}
			);
		}
//获得调查调用代码
function getvotecode(id) 
		{
			var str= "<script type='text/javascript'>showvote("+id+");</script>"
			clipboardData.setData('text',str);
			alert("代码已复制到粘贴板");
		}
