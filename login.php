<?php
session_start();
include_once "conn.php";
$username = $_GET["username"];
$password = md5 ( $_GET["password"] );
if($username==NULL||$username==""||$password==NULL||$password=="")
{
	if($_COOKIE["username"]==NULL||$_COOKIE["username"]=="")
		die("notlogin");
}
	try {
		$query = "select * from I_user where username = '" . $username . "' and password = '" . $password . "'";
		//echo $query;
		$result = getresult ( $query );
		if (getresultNumrows ( $result )<1) {
			throw new Exception ( "登录失败！" );
		} else {
			if(getresultData ( $result, 0, "iflock" )==="1")
			{
				die("locked");
			}
			setcookie ( "username", getresultData ( $result, 0, "username" ) );	
			setcookie ( "userid", getresultData( $result, 0, "id" ));
			$_SESSION["username"] = getresultData ( $result, 0, "username" );
			$_SESSION["userid"] = getresultData( $result, 0, "id" );
			getresult ( "update I_user set logintimes=logintimes+1 where id=".getresultData ( $result, 0, "id" ) );
			//echo "update I_admin set logintimes=logintimes+1,lastip=".$_SERVER["REMOTE_ADDR"].",lasttime=CURRENT_TIMESTAMP where id=$id";
			//echo getlogininfo("adminname");
			echo ("logined");
		}
	} catch ( Exception $e ) 
	{
		//die ( "notlogin" );
	}
?>