var xmlHttp

function jspost(str,divid)
{
if (str.length==0)
  { 
  document.getElementById(divid).innerHTML=""
  return
  }
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
  {
  alert ("Browser does not support HTTP Request")
  return
  } 
var url=str
url=url+"&sid="+Math.random()
url=encodeURI(url); 
xmlHttp.onreadystatechange=function(){stateChanged(divid)};
xmlHttp.open("GET",url,true)
xmlHttp.send(null)

} 

function stateChanged(divid) 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById(divid).innerHTML=xmlHttp.responseText 
 } 
}

function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}