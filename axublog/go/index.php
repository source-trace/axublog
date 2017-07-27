<?php


$u=$_GET['u'];
$u=strtolower($u);


$u='http://'.str_replace('http://','',$u);



?>
<script>location.href="<?=$u?>"</script>