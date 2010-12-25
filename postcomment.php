<?php
    include_once 'conn.php';
    include_once 'frontshowfunction/frontbasefunction.php';
    $articleid = $_POST["articleid"];
    $preurl = $_POST["preurl"];
    //如果是回复
    $quoteid = $_POST["quoteid"];//$quoteid为要回复的comment的id
    
    $commentcontent = $_POST["commentcontent"];
    
	$commentcontent = htmlentities($commentcontent); 
    //用户信息
    $username = getUserInfo("username");
    if($username=="notdefined")
        $username = "anonymity";
    $userip = GetUserIP();
    if($quoteid==NULL||$quoteid=="")
        $sql = "insert into I_comment(articleid,username,addtime,commentcontent,userip)
                values($articleid,'$username','".date("Y-m-d H:i:s")."','$commentcontent','$userip')";
    else
        $sql = "insert into I_comment(articleid,username,addtime,commentcontent,userip,quoteid)
                values($articleid,'$username','".date("Y-m-d H:i:s")."','$commentcontent','$userip',$quoteid)";
    //echo $sql."\n";
    if(getresult($sql))
    {
        //添加评论成功;
        echo "success";
    }
    else
    {
        //添加评论失败
        echo "fail";
    }
?>