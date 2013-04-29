<?php
	class Log
	{
		var $id;//日志编号
		var $adminName;//管理员名
		var $logType;//日志类型
		var $operateContent;//操作内容
		var $ip;//所在ip
		var $operateTime;//操作时间
		function Delete()
		{
			//删除评论
			if($id==NULL || $id < 1)
				return false;
			if(!getresult("delete * from I_log where id=".$id))
				return false;
			return true;
		}
		function Add()
		{
			$insertsql = "insert into I_log(adminname,logtype,operatecontent,ip) values('".$this->adminName."',".$this->logType.",'".$this->operateContent."','".$this->ip."')";
			if($this->adminName==NULL||$this->adminName==""||$this->operateContent==NULL||$this->operateContent==""||$this->ip==NULL||$this->ip=="")
			{
				return false;
			}
			if(!getresult($insertsql))
			{
				return false;
			}
			return true;
		}
	}
	//以下是操作函数
	class Logs
	{
		var $allLogs = array();
		var $pageSize;
		var $currentPage;
		function getAllLog($currentpage, $pagesize=10,$logtype=0)
		{
			$sql = "select * from I_log where logtype=$logtype  order by id desc  limit ".($currentpage-1)*$pagesize.",$pagesize";
			//echo $sql;
			$result = getresult($sql);
			$i = 0;
			while($row = getresultarray($result))
			{
				$this->allLogs[$i] = new Log();
				//echo $row["id"];
				$this->allLogs[$i]->id = $row["id"];
				$this->allLogs[$i]->adminName = $row["adminname"];
				$this->allLogs[$i]->operateContent = $row["operatecontent"];
				$this->allLogs[$i]->ip = $row["ip"];
				$this->allLogs[$i]->operateTime = $row["operatetime"];
				//echo $allLogs[$i]->id;
				$i++;
			}
			//print_r($this->allLogs);
		}
		function showAllLog()
		{	
			if(count($this->allLogs)<1)
			{
				echo "<tr class='list'>\n";
				echo "<td colspan='6' align='center'>".gettext_r("haveNot").gettext_r("log")."</td>";
				echo "</tr>\n";
				return;
			}
			foreach($this->allLogs as $key => $value)
			{
				echo "<tr class='list'>\n";
				echo "	  <td align='center'><input type='checkbox'  name='list'  value='".$value->id."'></td>\n";
				echo "    <td align='center'>".$value->id."</td>\n";
				echo "    <td align='center'>".$value->adminName."</td>\n";
				echo "    <td>".$value->operateContent."</td>\n";
				echo "    <td align='center'>".$value->ip."</td>\n";
				echo "    <td align='center'>".$value->operateTime."</td>\n";
				echo "</tr>\n";
			}
		}
		//分页
		function showLogpage($currentpage, $pagesize=10,$logtype=0)
		{
			$tempresult = getresult("select count(*) as countoflog from I_log where logtype=$logtype");
		
			$countoflog = getresultData($tempresult, 0, "countoflog");
			if($countoflog%$pagesize == 0)
				$allpage = $countoflog/$pagesize;
			else
				$allpage = floor($countoflog/$pagesize) + 1;
			//消除文章数为零时显示下一页链接的bug
			if($countoflog==0)
				$allpage += 1;
			
			//echo $countofcomment%$pagesize." ".$currentpage;
			echo gettext_r("total")."<b> ".$allpage." </b>".gettext_r("page")."(".$pagesize." ".gettext_r("piece").gettext_r("article").gettext_r("per").gettext_r("page").")　";
			if($currentpage==1)
				echo gettext_r("firstPage")." | ".gettext_r("prePage")." | ";
			else
				echo "<a href='admin_log.php?logtype=$logtype&currentpage=1'>".gettext_r("firstPage")."</a> | <a href='admin_log.php?logtype=$logtype&currentpage=".($currentpage-1)."'>".gettext_r("prePage")."</a> | ";
			
			$temppage = 1;
			if(($currentpage-1)<5)
				while($temppage <= $currentpage)
				{
					if($currentpage==$temppage)
					{
						echo "<b>".$temppage."</b> ";
						$temppage++;
						continue;
					}
					echo "<a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> ";
					$temppage++;
				}
			else
				while($temppage <= $currentpage)
				{
					if($currentpage==$temppage)
					{
						echo "<b>".$temppage."</b> ";
						$temppage++;
						continue;
					}
					if($temppage==1)
					{
						echo "<a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> … ";
						$temppage++;
						continue;
					}
					if(($currentpage-$temppage)>3)
					{
						$temppage++;
						continue;
					}
					echo "<a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> ";
					$temppage++;
				}
			if(($allpage-$currentpage)<5)
				while($temppage <= $allpage)
				{
					if($temppage==1)
					{
						echo "<a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> ";
						$temppage++;
						continue;
					}
					echo "<a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> ";
					$temppage++;
				}
			else
				while($temppage <= $allpage)
				{
					if($temppage==$allpage)
					{
						echo " … <a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> ";
						$temppage++;
						continue;
					}
					if(($temppage-$currentpage)>3)
					{
						$temppage++;
						continue;
					}
					echo "<a href='admin_log.php?logtype=$logtype&currentpage=$temppage'>".$temppage."</a> ";
					$temppage++;
				}
			
			if($currentpage==$allpage)
				echo "| ".gettext_r("nextPage")." | ".gettext_r("lastPage");
			else
				echo "| <a href='admin_log.php?logtype=$logtype&currentpage=".($currentpage+1)."'>".gettext_r("nextPage")."</a> | <a href='admin_log.php?logtype=$logtype&currentpage=$allpage'>".gettext_r("lastPage")."</a>";
		}
	}
?>