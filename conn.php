<?php
	function myErrorHandler($errno, $errstr, $errfile, $errline)
	{
		switch ($errno) 
		{
			//严重错误
			case E_ERROR:
			case E_USER_ERROR:
				echo $errfile." ".$errline.":".$errstr;
				break;
			case E_WARNING:
			case E_USER_WARNING:
				//echo $errfile." ".$errline.":".$errstr;
				//break;
			default:
				return true;
		}
		echo "<br>Sorry! Error Arise!<br>Click <a href='/'>here</a> to go to home page~";	
		/* Don't execute PHP internal error handler */
		die();
	}
	//设置错误处理程序
	set_error_handler("myErrorHandler");
	
	try{
	$link_mysql = mysql_pconnect("localhost","root","142232");
	mysql_query("SET NAMES 'utf8'");  
	if(!$link_mysql)
		throw new Exception("Can't connect the database server!");
	mysql_select_db("iron_cms",$link_mysql) or die("Have no such database!");
	
	}catch(Exception $e){
		die($e->getMessage());
	}
	//数据库函数
	function getresult($query)
	{
		return mysql_query($query);
	}
	function getresultNumrows($result)
	{
		return mysql_num_rows($result);
	}
	function getresultArray($result)
	{
		return mysql_fetch_array($result);
	}
	function getresultRow($result)
	{
		return mysql_fetch_row($result);
	}
	function getresultData($result,$row,$field)
	{
		return mysql_result($result,$row,$field);
	}
	function getaffectedrows()
	{
		return mysql_affected_rows();
	}
	
?>
