/*************************************************************************
  This code is from Dynamic Web Coding at dyn-web.com
  Copyright 2001-5 by Sharon Paine 
  See Terms of Use at www.dyn-web.com/bus/terms.html
  regarding conditions under which you may use this code.
  This notice must be retained in the code as is!
*************************************************************************/

/* 
    dw_scrollObj.js  version date: March 2005
    GeckoTableBugFix algorithm revised, and now excludes Safari and Konqueror.
    
    dw_scrollObj.js contains constructor and basic methods for scrolling layers.
    Use with dw_hoverscroll.js and/or dw_glidescroll.js,
    and for scrollbars: dw_scroll-aux.js and dw_slidebar.js
*/

/*  Readable code available for licensed users */
dw_scrollObjs = {};
dw_scrollObj.speed = 100; // default speed for mouseover scrolling


function dw_scrollObj(wnId,lyrId,cntId){
	this.id=wnId;
	dw_scrollObjs[this.id]=this;
	this.animString="dw_scrollObjs."+this.id;
	this.load(lyrId,cntId);
};

dw_scrollObj.loadLayer=function(wnId,id,cntId){
	if(dw_scrollObjs[wnId])dw_scrollObjs[wnId].load(id,cntId);
};

dw_scrollObj.prototype.load=function(lyrId,cntId){
	if(!document.getElementById)return;
	var wndo,lyr;
	if(this.lyrId){
		lyr=document.getElementById(this.lyrId);
		lyr.style.visibility="hidden";
	}
	lyr=document.getElementById(lyrId);
	wndo=document.getElementById(this.id);
//alert("lyr="+lyr+"    lyrId="+lyrId);
//alert("wndo="+wndo+"    this.id="+this.id);
	lyr.style.top=this.y=0;
	lyr.style.left=this.x=0;
    this.maxY = (lyr.offsetHeight - wndo.offsetHeight > 0) ? lyr.offsetHeight - wndo.offsetHeight : 0;
    this.wd = cntId ? document.getElementById(cntId).offsetWidth : lyr.offsetWidth;
    this.maxX = (this.wd - wndo.offsetWidth > 0) ? this.wd - wndo.offsetWidth : 0;
    this.lyrId = lyrId;
    lyr.style.visibility = "visible";
    this.on_load();
    this.ready = true;
}	

var dw_Inf={};
dw_Inf.fn=function(v){
	return eval(v)
};
	
dw_scrollObj.prototype.on_load = function(){};
	
dw_scrollObj.prototype.shiftTo = function(lyr,x,y) { 
	//if (!lyr.style||!dw_scrollObj.scrdy) return;
	if (!lyr.style) return;
	lyr.style.left=(this.x=x)+"px";
	lyr.style.top=(this.y=y)+"px";
};
	
dw_scrollObj.GeckoTableBugFix = function(){
	var ua = navigator.userAgent;
    if (ua.indexOf("Gecko") > -1 && ua.indexOf("Firefox") == -1 && ua.indexOf("Safari") == -1 && ua.indexOf("Konqueror") == -1) {
         dw_scrollObj.hold = [];
         for (var i = 0; arguments[i]; i++) {
           if (dw_scrollObjs[arguments[i]]) {
                var wndo = document.getElementById(arguments[i]);
                var holderId = wndo.parentNode.id;
                var holder = document.getElementById(holderId);
                document.body.appendChild(holder.removeChild(wndo));
                wndo.style.zIndex = 1000;
                var pos = getPageOffsets(holder);
                wndo.style.left = pos.x + "px";
                wndo.style.top = pos.y + "px";
                dw_scrollObj.hold[i] = [arguments[i], holderId];
            }
        }
        window.addEventListener("resize", dw_scrollObj.rePositionGecko, true);
     }
 }	

dw_scrollObj.rePositionGecko = function() { 
	if (dw_scrollObj.hold) {
		for (var i=0;dw_scrollObj.hold[i];i++) {
			var wndo = document.getElementById(dw_scrollObj.hold[i][0]);
	        var holder=document.getElementById(dw_scrollObj.hold[i][1]);
			var pos=getPageOffsets(holder);
			wndo.style.left=pos.x+"px";
			wndo.style.top=pos.y+"px";
		}
	}
};

function getPageOffsets(el){
	var left=el.offsetLeft;
	var top=el.offsetTop;
	if(el.offsetParent&&el.offsetParent.clientLeft||el.offsetParent.clientTop) {
		left+=el.offsetParent.clientLeft;
		top+=el.offsetParent.clientTop;
	}
	while (el=el.offsetParent) {
		left+=el.offsetLeft;
		top+=el.offsetTop;
	}
	return {x:left,y:top};
};
	
 
	