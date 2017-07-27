<?php



function runtime(){

 }
 
 function runtime2(){
global $starttime;
return '<div id=clear></div><p align=center>页面执行时间：'.sprintf("%.4f",microtime(true)-$starttime).'秒</p>';
 }



?>