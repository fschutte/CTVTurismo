<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
<style type="text/css" title="currentStyle" media="screen">
		@import "../theme/agenda.css";
</style>

<title>Agenda</title>

<script src="../js/mootools-1.2-core-yc.js" type="text/javascript"></script>
<script src="../js/mootools-1.2-more.js" type="text/javascript"></script>
	
</head>
<body>

<div id="agendapanel">
  
  <div id="controlpanel">
    <img src="../images/doublearrow2.gif" alt="" usemap="#doublearrowmap">
    
    <?php //doublearrow gif is oorspronkelijk 272px hoog; de coords van de areas worden gezet in domready en resize event ?>
    
    <map name="doublearrowmap">
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.goUp(12)" >
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.goUp(30)" >
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.goUp(50)" >
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.stop()" >
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.goDown(50)" >
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.goDown(30)" >
	    <area shape="rect" alt="" href="#" onclick="return false" onmouseover="scroller.goDown(12)" >
	</map>
  </div>

   <div id="scrollwindow">

<?php 
	       if ($_GET["country"]) 
	       	$country = $_GET["country"];
	       else 
	        $country = "nl";
	      
	       $agenda = "../agenda/agenda_" . $country . ".inc";

		   include($agenda); 
?>

   </div>


</div>	<!-- end agendapanel div -->



<script>
var scroller = null;

window.addEvent('domready', function(){

	// make space at top and bottom at least as big as size of the offset
	var scrollwindow = $('scrollwindow');
	var spacedivTop = new Element('div', {
		'class': 'spacediv'
	});
	var spacedivBottom = spacedivTop.clone();
	
	spacedivTop.inject(scrollwindow, 'top');
	spacedivBottom.inject(scrollwindow, 'bottom');

	adjustHeight();	
	
	window.addEvent('resize', function(){
		adjustHeight();
	});		

	scroller = new SpeedScroll('scrollwindow'); // moet gebeuren nadat de hoogte van element goed staat (adjustHeight)
	// start scrolling
	scroller.goDown(30);
});

function adjustHeight() {
	var windowSize = window.getSize();
	$('agendapanel').setStyle('height', windowSize.y -1);
	
	var scrollSize = $('scrollwindow').getSize();	
	$$('.spacediv').setStyle('height', scrollSize.y +10);
		
	var arrowHeight = scrollSize.y -2;
	$$('#controlpanel img').setStyle('height', arrowHeight);
	// pijl niet mee schalen tenzij de img map ook wordt meegeschaald
	
	var areas = $$('#controlpanel map area');
	var slice = Math.round(arrowHeight / areas.length);
	$each(areas, function(area, i){
    	area.set('coords', '0,'+slice*i+',20,'+slice*(i+1)); //pas coords van area in img map aan
	});

}




// simple class which uses Fx.Scroll
// methods: goUp(speed), goDown(speed)
// goUp(10) is fast. goUp(20) is slow
SpeedScroll = new Class({
	initialize: function(element){
		this.direction = 'hold';
		this.speed = 0; 
		this.element = this.subject = $(element);
		
		this.fxscroll = new Fx.Scroll(element, {
			wait: false,
			transition: Fx.Transitions.linear
		});
		// beetje een hack
		this.fxscroll.speedScroll = this;
		
		this.minY = 0; // we gaan van 0 tot maxY
		
		// let op: de scrollsize is natuurlijk groter dan de size. Om hier zeker van te zijn zouden we ook op dit punt de spaces ervoor en ernaar kunnen plakken.
		this.maxY = this.element.getScrollSize().y - this.element.getSize().y;
	
		this.deltaY = this.maxY - this.minY;
		
		
		this.fxscroll.addEvent(
			'complete', function(event) {
				// try to loop
				if (this.speedScroll.direction == 'up') {
					var y = this.speedScroll.maxY;					
					this.set(0,y);
					this.speedScroll.goUp(this.speedScroll.speed);
				} else if (this.speedScroll.direction == 'down') {
					this.set(0,0);
					this.speedScroll.goDown(this.speedScroll.speed);
				}
			});
	},
	goUp: function(speed){
		if (!$defined(speed)) speed = 5;
		this.direction = 'up';
		this.speed = speed;
		this.fxscroll.options.duration = this.calcDuration(speed);
		return this.fxscroll.toTop();
	},	
	goDown: function(speed){
		if (!$defined(speed)) speed = 5;
		this.direction = 'down';
		this.speed = speed;
		this.fxscroll.options.duration = this.calcDuration(speed);
		return this.fxscroll.toBottom();
	},	
	stop: function() {
		return this.fxscroll.cancel();
	},
	calcDuration: function(speed) {	
		var maxdur = speed * this.element.getScrollSize().y ;
		var curY = - this.element.getPosition().y; // somehow position is always negative
		var newdur = maxdur*((curY - this.minY)/this.deltaY);
		if (this.direction == 'down') {
			newdur = maxdur - newdur;
		}
		return newdur;
	}
});

</script>

</body>
</html>

