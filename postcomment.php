<?php
    include_once 'conn.php';
    include_once 'frontshowfunction/frontbasefunction.php';
    $articleid = $_POST["articleid"];
    $preurl = $_POST["preurl"];
    //����ǻظ�
    $quoteid = $_POST["quoteid"];//$quoteidΪҪ�ظ���comment��id
    
    $commentcontent = $_POST["commentcontent"];
    
	$commentcontent = htmlentities($commentcontent); 
    //�û���Ϣ
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
        //������۳ɹ�;
        echo "success";
    }
    else
    {
        //�������ʧ��
        echo "fail";
    }
?>