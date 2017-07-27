
function scroll( fn ) {
    var beforeScrollTop = document.body.scrollTop,  
        fn = fn || function() {};  
    window.addEventListener("scroll", function() {  
        var afterScrollTop = document.body.scrollTop,  
            delta = afterScrollTop - beforeScrollTop;  
        if( delta === 0 ) return false;  
        fn( delta > 0 ? sdown() : sup() );  
        beforeScrollTop = afterScrollTop;  
    }, false);  
}  

function sdown(){
document.getElementById("t1").style.lineHeight="normal";
document.getElementById("topmenu").style.height="30px";
document.getElementById("topmenu2").style.lineHeight="30px";
document.getElementById("t3").style.lineHeight="30px";
document.getElementById("topmenu").style.fontSize="12px";
	document.getElementById("wxlogo").style.width="40px";
}

function sup(){
document.getElementById("t1").style.lineHeight="26px";
document.getElementById("topmenu").style.height="50px";
document.getElementById("topmenu2").style.lineHeight="50px";
document.getElementById("t3").style.lineHeight="50px";
document.getElementById("topmenu").style.fontSize="15px";
	document.getElementById("wxlogo").style.width="40px";
}

function ietopmenu(){
document.getElementById("all").style.paddingTop="50px";
document.getElementById("t1").style.lineHeight="normal";
document.getElementById("topmenu").style.height="30px";
document.getElementById("topmenu2").style.lineHeight="30px";
document.getElementById("t3").style.lineHeight="30px";
document.getElementById("topmenu").style.fontSize="12px";
}
function hidewx(){
document.getElementById("wxlogo").style.width="40px";
}
function showwx(){
document.getElementById("wxlogo").style.width="150px";
}

