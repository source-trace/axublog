<?php
require("cmsconfig.php");



$g=$_GET['g'];


if ($g=='arthit'){
$id=$_GET['id'];
    if($id!=''){
    
$tab=$tabhead."arts";
mysql_select_db($tab);
$sql=mysql_query("UPDATE ".$tab." SET hit=hit+1 where id=".$id);
$sql = mysql_query("select * from ".$tab." where id=".$id);
$row=mysql_fetch_array($sql);
    $str=$row['hit'];
    echo 'document.write('.$str.');';
    }
}



?>