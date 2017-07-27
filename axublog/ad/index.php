<?php 
include_once("all.php");
chkadcookie();
@$g=$_GET["g"];
$main="right.php";


				@$chkmoblie=isMobile();
				if($chkmoblie==1&&$g==''){echo'<meta http-equiv="refresh" content="0;url=wap.php">';
				}
?>
<html>
<head>
<title><?=$webname?>-后台管理-Powered by <?=$codename?></title>
<meta http-equiv=Content-Type content=text/html;charset=utf-8>

<link rel="shortcut icon" href="images/favicon.ico" >
<link rel="icon" href="images/favicon.ico" type="image/gif" >
</head>

<? switch ($g)
    {
    case "admin.php":$main="admin.php";
    }
?>
<frameset rows="45,*,37">
<frame src="top.php" noresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />


<frameset cols="272,*">
<frame src="left.php" name="leftFrame" noresize="noresize" marginwidth="0" marginheight="0" frameborder="0" scrolling="no" target="main" />
<frame src="<?=$main?>" name="main" marginwidth="0" marginheight="0" frameborder="0" scrolling="auto" target="_self" />
</frameset>

<frame src="copy.php" noresize="noresize" frameborder="NO" name="topFrame" scrolling="no" marginwidth="0" marginheight="0" target="main" />
</frameset>






</html>