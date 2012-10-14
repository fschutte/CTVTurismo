<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<?php
/*We gaan weer terug naar een vorige versie. Hierbij moet ik de laatste versie enigszins mergen met 
 *een oude correcte versie.

1. zorgen dat layout enigszins gelijk is aan de nieuwste
2. zorgen dat pagina is opgeschoond: mediaplayer verwijderen, alles wat overbodig is weg
 * 
 */
?>

<?php
require_once 'Zend/Loader.php';

Zend_Loader::loadClass('Zend_Gdata_YouTube');

include_once('inc/glocalizationutil.php');
include_once('inc/vladys_prefs.php');
# sets the $YOUTUBE_VIDEO_ID 


/*
 * The following functions enable us to easily insert youtube videos.
 * Off course, it would be better to structure this in neat classes etc. sometime in the future.
 */

class YoutubeVideo {
  var $escTitle, $title, $url;
}

function findFlashUrl($entry) {
    foreach ($entry->mediaGroup->content as $content) {
    	//print "<!-- " . $content . "-->\n";  //debug
        if ($content->type === 'application/x-shockwave-flash') {
            return $content->url;
        }
    }
    return null;
}

function getYoutubeVideo($videoId) {
	$video = new YoutubeVideo();     
  $yt = new Zend_Gdata_YouTube();
  $entry = $yt->getVideoEntry($videoId);
  //$videoId = $entry->getVideoId();
  //$thumbnailUrl = $entry->mediaGroup->thumbnail[0]->url;
  $video->title = $entry->mediaGroup->title;
  $video->escTitle = addslashes($video->title);
  //$videoDescription = $entry->mediaGroup->description;
  $video->url = findFlashUrl($entry);  
  return $video;
} 

?>

<html>

<head>
<title>Total Salsa Agenda</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="Total Salsa Agenda">
<meta name="keywords" content="CTV,webtv,latin,music,video clips,television,reggeaton,salsa,bachata">

		<script src="js/mootools-1.2.5-core-yc.js" type="text/javascript"></script> 
		<script src="js/mootools-1.2.5.1-more.js" type="text/javascript"></script>
<script src="js/mootools-1.2-cnet-slideshow.compressed.js" type="text/javascript"></script>

<script>
/* my lightbox */
			function openImage(url) {				
				$('myImage').setProperty('src', url);
			}
			
			function closeImage() {
				document.getElementById('light').style.display='none';
				document.getElementById('fade').style.display='none';
			}
			
			function onImageLoad() {
					var imgElt = $('myImage');
					var size = imgElt.measure(function(){  // measure is een Mootools util om met niet zichtbare elementen te werken
	    				return this.getSize();
					});
					var w = size.x;
					var h = size.y;
					
					if (h > w) { // bij een portrait moet hoogte maximaal (90% van scherm)
						$('light').setStyles({
						    top: '5%',
						    left: '25%',
						    height: '90%'
						});
						$('myImage').setStyle('height', '100%');
						$('myImage').setStyle('width', '');
						// size moet na de resizing van de image opnieuw bepaald worden
						var ww = $('myImage').getStyle('width');
						$('light').setStyle('width', ww);
						
					} else {  // bij een landscape moet width maximaal
						$('light').setStyles({
						    left: '5%',
						    width: '90%',
						});
						$('myImage').setStyle('width', '100%');
						$('myImage').setStyle('height', '');
						// size moet na de resizing van de image opnieuw bepaald worden
						var hh = $('myImage').getStyle('height');
						$('light').setStyle('height', hh);
						// bepaal vertical alignment obv ratio van image
						var ratio = w/h;
						//alert('ratio w/h='+w+'/'+h+'='+ratio);
						if (ratio < 1.5) {
							$('light').setStyle('top', '5%');
						} else {
							$('light').setStyle('top', '20%');
						}
					}
					
					document.getElementById('light').style.display='block';
					document.getElementById('fade').style.display='block';
			}
</script>

<link href="theme/menustyle.css" rel="stylesheet" type="text/css">

	
	<style>
	/* my lightbox */
		.black_overlay{
			display: none;
			position: absolute;
			top: 0%;
			left: 0%;
			width: 100%;
			height: 100%;
			background-color: black;
			z-index:1001;
			-moz-opacity: 0.8;
			opacity:.80;
			filter: alpha(opacity=80);
		}
		.white_content {
			display: none;
			position: absolute;
			/*top: 5%;*/
			/*left: 25%;*/
			/*width: 50%;*/ /* width berekenen obv image */
			/* height: 90%;*/  /* height berekenen obv image */
			padding: 0px;
			border: 2px solid orange;
			background-color: white;
			z-index:1002;
			/*overflow: auto;*/
		}
	</style>
	
<style>
body {
	margin: 0;
	padding: 0;
	text-align: center;
	background-position: left top;
	background-color: #f0f0f0;
	/*background-image: url(images/bgx5.jpg);*/
	background-repeat: repeat;
}

#header-area {
	width:920px;
	height:300px;
	position:absolute;
	left:0;
}

#header {
	margin-left:1px;
	height:272px;
	width:915px;
	background-image: url(images/header-playa-918x272.png);
}

#menu-area {
	width: 438px;  /* sum of menu items for center alignment*/ 
	height:30px;
	margin-top: 0px;
	margin-left: auto;
	margin-bottom: 0;
	margin-right: auto;
	top: -15px;
	position: relative;

}

#outer-main-area {
  /* area includes content area and video area and ad */
	width: 1080px;   /* make sure width is bigger than divs inside area */
	height:900px;
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 0;
	margin-left: auto;
	position: relative;
/*border:1px solid blue; */
}

#main-area {
  /* area includes content area and video area */
	width: 920px;   /* make sure width is bigger than divs inside area */
 	height:900px;
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 0;
	margin-left: auto;
	position:absolute;
	left:0;
	top:0;
	background-position: left top;
	background-color: #000;
	background-image: url(images/bg-sand4.gif);
	background-repeat: repeat;
	z-index:2;
	border-bottom:2px solid gray;
	border-left:1px solid gray;
	border-right:1px solid gray;
}

#content-area {
	position:absolute;
	width: 468px;
	height: 400px;
	margin-right: 0px;
	margin-top: 10px;
	margin-left: 0px;
	top:300px;
left:15px;
}

#ads-content {
  /* boxje voor google ad onder infoframe */
	text-align: right; 
	margin-top: 9px;
}

#infoframe {
	border: 1px solid black;
	/*width: 440px;*/
	width: 466px;
	height: 323px; 
}

#video-area {
	position:absolute;
	top:300px;
	right:0;
	/*width: 420px;*/
	width: 420px;
	height: 400px;
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
/*border: 1px solid blue;*/
}
#textVideoPlaceholder {
	font-size: 10px; 
	height: 8px;   /* hiermee kunnen we de ruimte tussen de video en logos sturen */
	margin-top: 5px;
}
	
#ads-video {
	margin-left: 20px;
}


#skyscraper-area {
	float:right;
	margin-top:0px;
	width: 160px;
	height: 600px;
}

#footer-main-area {
	position:absolute;
	bottom:0px;
	left:6px;
	width:909px;
	height:570px;
	/*background-color:white;*/
	z-index:-3;
	/*background-image: url(images/bg1280x1024_trans_gray.jpg);*/
}

#google-search {
	top: 395px;
	right: 9px;
	position:absolute;
}

#disclaimer {
	font-size:small;
	position:absolute;
	bottom:1px;
	width:100%;
}

#footer {
	clear: both;
}


#ads {
	margin-left: 0px;
}

.logo {
	border: 0px;
/*	border: 1px solid black; */
}



</style>

<!--[if lte IE 6]>
<style type="text/css" media="screen">
/* csshover.htc file version: V1.21.041022 - Available for download from: http://www.xs4all.nl/~peterned/csshover.html */
body{behavior:url(theme/csshover.htc);
}
</style>
<![endif]-->

	     <?php
	     
	     	$showRadio = false;
	     	
	     	# first check if page was called with parameter country
	        if ($_GET["country"]) 
	       		$c = $_GET["country"];
	       	# second check the country of the visitor (glocalizationutil)
	        else {
	        	$c = getVisitorCountry();
	        }
	        $c = strtolower($c);
	        
	        echo "\n<!-- FS:  c = $c -->\n";
	        $DEFAULT_SUPPORTED_COUNTRIES = array("nl", "ar", "ch", "it", "ec", "be", "pl", "de", "ru", "es", "uk", "co");
	        if (!isset($SUPPORTED_COUNTRIES)) $SUPPORTED_COUNTRIES = $DEFAULT_SUPPORTED_COUNTRIES;
	        
	       
			// default to nl if country was unknown	        
	        if (in_array($c, $SUPPORTED_COUNTRIES)) {
		       	$country = $c;
	        } else {
		        $country = "nl";
		    }
	       	echo "\n<!-- FS:  country = $country -->\n";        
	       $defaultStartingPage = "party_flyers.php?country=" . $country;
	       echo "\n<!-- FS:  defaultStartingPage = $defaultStartingPage -->\n";
	       if ($_GET["p"])
	       		$p = $_GET["p"];
	       	
	       if ($p=="chat") {
	       		$page = "chat/flashchat.php";
	       } else if ($p=="news") {
	       		$page = "news/newsletter.html";
	       } else if ($p=="contact") {
	       		$page = "ctvinfo/formulario.html";
	       } else if ($p=="radio") {
	       		$page = "chat/flashchat.php";
	       		$showRadio = true;
	       } else if ($p=="agenda") {
	       		$page = "agenda/agenda.php?country=" . $country;
	       } else if ($p=="flyers") {
	       		$page = "party_flyers.php?country=" . $country;
	       } else {
	       		// default starting page
	       		$page = $defaultStartingPage;
	       }		
	       		
	       	echo "\n<!-- FS:  page = $page -->\n";
	      ?> 

<script>

var COPYRIGHT_TXT = 'Copyright &copy; 2012 Total Salsa Agenda. Derechos reservados.';

var mySlideShow = null; // fill in when dom is ready

function timedLoop(interval) {
	mySlideShow.forward();
	setTimeout('timedLoop('+interval+')', interval);
}

window.addEvent('domready', function(){
	//updateSalto('<?php echo "${INITIAL_SALTO_VIDEO}"; ?>');
	//$('SpanUnderVideo').set('html', 'LOADING....');
	//$('SpanUnderVideo').set('html', COPYRIGHT_TXT);   // niet meer nodig...
	
	$('disclaimer').set('html', COPYRIGHT_TXT);
	
	<?php if ($showRadio) { 
		echo "$('mediadiv').set('html', radiohtml);";
	} else {
		//FS-since 2009 the live wmp stream has finished
		//echo "showWmpStream('ctvstream.php')";

		// TODO error handling	
		
		if ($START_WITH_YOUTUBE_PLAYLIST) {
			// first check if specific country playlist title and url exists
			$varCountryPLTitle = "\${YOUTUBE_PLAYLIST_TITLE." . $country . "}";
			$varCountryPLUrl = "\${YOUTUBE_PLAYLIST_URL." . $country . "}";
			
			$toEval = "if (isset($varCountryPLTitle))   \$countryPLTitle = \"$varCountryPLTitle\"; ";
			eval($toEval);
			$toEval = "if (isset($varCountryPLUrl))   \$countryPLUrl = \"$varCountryPLUrl\"; ";
			eval($toEval);
		
			// use country specific playlist or else use default
			$plTitle = isset($countryPLTitle) ? $countryPLTitle : $YOUTUBE_PLAYLIST_TITLE;
			$plUrl = isset($countryPLUrl) ? $countryPLUrl : $YOUTUBE_PLAYLIST_URL;
			
			$escTitle = addslashes($plTitle);
			echo "updateVideo('$escTitle','$plUrl');";
		
		} else {
			//starten met een youtube video
			$v = getYoutubeVideo($YOUTUBE_VIDEO_ID);
	        echo "updateVideo('". $v->escTitle ."','". $v->url ."');";
		}        
        
	} ?>


	// logo slideshow	
	mySlideShow = new SimpleSlideShow({
	  	startIndex: 0,
	  	slides: $$('div#logoSlideShow a'),
	  	container: 'logoSlideShow',
	  	crossFadeOptions: {transition: Fx.Transitions.Sine.easeInOut}
	});
	timedLoop(7000); // autoloop the logos
	
});


// show windows media video
function showWmpStream(wmpstream) {
	var newhtml = tvhtml.replace(/{THESTREAM}/g, wmpstream);
	$('mediadiv').set('html', newhtml);
}
			
function updateVideo(videoTitle, videoUrl) {
		var p1 = document.getElementById("MediaPlayer1");
		var p2 = document.getElementById("MediaPlayer1Embed");
		// somehow in IE it works better if we first stop the movie before loading video over it
		if (p1!=null && p2==null) {
			try {
				// old version wmp  
				//p1.stop() 
				// new version wmp (6+)
				p1.controls.stop();
			} catch (e) {} // never mind if it does not work 
			setTimeout("updateVideoObject('"+videoTitle+"', '"+videoUrl+"')", 100);  // bit delay because of some strange IE versions
		} else {
			updateVideoObject(videoTitle, videoUrl);
		}
}

function updateVideoObject(videoTitle, videoUrl) {
	//var s =     '<b>' + videoTitle + '</b><br /><object width="390" height="300">'
    //  + '<param name="movie" value="'+ videoUrl + '&autoplay=1&fs=1"></param>'
    //  + '<param name="wmode" value="transparent"></param>'
    //  + '<param name="allowFullScreen" value="true"></param>'
    //  + '<embed src="'+ videoUrl + '&autoplay=1&fs=1" type="application/x-shockwave-flash" wmode="transparent" allowfullscreen="true" width=390" height="300"></embed>'
    //  + '</object>';

	// as of May 2012, Youtube playlist embedding should not be done anymore via flash object, but with an iframe
	// this way Youtube can offer html5 video as well as flash
	var s = '<b>' + videoTitle + '</b><br /><iframe width="390" height="300" '
	  + ' src="'+ videoUrl +'" '
	  + ' frameborder="0" allowfullscreen>'
	  + '</iframe>';

    $('mediadiv').set('html', s);
}

//ustreamtv embed link
//var radiohtml ='<embed flashvars="viewcount=false&amp;autoplay=false&amp;brand=embed" width="380" height="300" allowfullscreen="true" allowscriptaccess="always" id="utv651331" src="http://www.ustream.tv/flash/live/268011" type="application/x-shockwave-flash" />';
var radiohtml = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="380" height="300" id="utv223676"><param name="flashvars" value="viewcount=false&amp;autoplay=false&amp;brand=embed"/><param name="allowfullscreen" value="true"/><param name="allowscriptaccess" value="always"/><param name="movie" value="http://www.ustream.tv/flash/live/295010"/><embed flashvars="viewcount=false&amp;autoplay=false&amp;brand=embed" width="380" height="300" allowfullscreen="true" allowscriptaccess="always" id="utv223676" name="utv_n_186468" src="http://www.ustream.tv/flash/live/295010" type="application/x-shockwave-flash" /></object>';

      var tvhtml = 
      			//'<object id="MediaPlayer1" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715"'
      			'<object id="MediaPlayer1" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" '
      			+ ' standby="Loading Microsoft Windows� Media Player components..." type="application/x-oleobject"'  
            	+ '		width="380" height="300" >'
				//+ '<param name="fileName" value="{THESTREAM}">'
				+ '<param name="URL" value="{THESTREAM}">'
				+ '	<param name="animationatStart" value="true">'
				+ '	<param name="transparentatStart" value="true">'
				+ '	<param name="autoStart" value="true">'
				+ '	<param name="showControls" value="false">'
				+ '	<param name="ShowStatusBar" value="false">'
				+ '	<param name="autoSize" value="false">'
				+ '	<param name="stretchToFit" value="true">'
				+ '	<param name="displaySize" value="false">'
				+ '	<param name="enableContextMenu" value="true">'
				+ '	<param name="uiMode" value="none">'
			+ '	<embed type="application/x-ms-wmp" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="{THESTREAM}"' 
			+ '		name="MediaPlayer1" '
			+ '		id="MediaPlayer1Embed"'
			+ '		enableJavascript="true"'
			+ '		mayscript="true"'
			+ '		scriptable="true"' 
			+ '		stretchToFit="true"'
			+ '		width="380" height="300"' 
			+ '		autostart="1" '
			+ '		showcontrols="0"' 
			+ '		transparentAtStart="1"'
			+ '		animationAtStart="1"'
			+ '		autoSize="0"'
			+ '		ShowStatusBar="0"'
			+ '		ShowControls="0"'
			+ '		displaySize="0"'
			+ '		enableContextMenu="1"'
			+ '		uiMode="none"'
			+ '		align="center">'
			+ '</object>';

// arg date format is yymmdd
function updateSalto(date) {
	// we have to stop the old screen in IE, otherwise the new object is shown below the old one
		var p1 = document.getElementById("MediaPlayer1");
		var p2 = document.getElementById("MediaPlayer1Embed");
		// somehow in IE it works better if we first stop the movie before loading video over it
		if (p1!=null && p2==null) {  
			p1.stop()
			setTimeout("updateSaltoObject('"+date+"')", 100);  // bit delay because of some strange IE versions
		} else {
			updateSaltoObject(date);
		}
}

function updateSaltoObject(date) {
	var newhtml = tvhtml.replace(/{THESTREAM}/g, "mms://195.169.148.57/LogDepotStream/6/"+date+"1900.asf");
	$('mediadiv').set('html', newhtml);
}


// if we press the extra menu then show a video retrieved with ajax
function menuExtra() {
	$('SpanUnderVideo').set('html', 'LOADING EXTRA VIDEO......');
	var jsonRequest = new Request.JSON({url: "ajax_youtube_extra.php", onComplete: function(yt){
	    if ($chk(yt.exceptionMsg)) {
	    	alert("Trouble finding the extra video. Please try again later.\n\n Problemas con cargar el video extra. Por favor, ententelo mas tarde.");
	    } else {
		    updateVideo(yt.videoTitle, yt.videoUrl);
		}   
		$('SpanUnderVideo').set('html', COPYRIGHT_TXT);
	}}).get({'videoId': '<?php echo "${MENU_EXTRA_VIDEO_ID}"; ?>'});
}

// if we press menu radio then start radio and place chatbox
function menuRadio() {
	$('mediadiv').set('html', radiohtml);
// 	$('infoframe').set('src', 'chat/flashchat.php');
}
</script>

<!-- google analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-33415921-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>

<body> 

<!--  my lightbox -->
		<div id="light" class="white_content"><a href="javascript:void(0)" onclick="closeImage()"><img id="myImage" onload="onImageLoad()" style="height:100%; margin:0; padding:0; border:0"/></a></div>
		<div id="fade" class="black_overlay" onclick="closeImage()"></div>
<!-- tot hier -->

<div id="outer-main-area">

<div id="main-area">

<div id="header-area">
	<div id="header">
		<!-- filled with css -->
	</div>
	
	
    
<!--|**START IMENUS**|imenus0,inline-->
<div id="menu-area" class="imrcmain0 imgl" style="z-index: 999999; position: relative;">
<div class="imcm imde" id="imouter0">
<ul id="imenus0">

	<li style="width: 50px;"><a href="<?php echo $_SERVER["REQUEST_URI"] ?>"><span class="imea imeam"></span>HOME</a></li>
	
	<?php 
	/*
	<li  style="width: 100px;"><a href="#"><span class="imea imeam"></span>COUNTRY/PAIS</a>
		<div class="imsc">
			<div class="imsubc" style="width: 85px; top: -2px; left: -1px;">
				<ul style="">
					<li><a href="agenda/agenda.php?country=nl" target="infoframe">Nederland</a></li>
					<li><a href="agenda/agenda.php?country=ar" target="infoframe">Argentina</a></li>					
					<li><a href="agenda/agenda.php?country=be" target="infoframe">Belgium</a></li>
					<li><a href="agenda/agenda.php?country=ch" target="infoframe">Switzerland</a></li>
					<li><a href="agenda/agenda.php?country=it" target="infoframe">Italia</a></li>
					<li><a href="agenda/agenda.php?country=ec" target="infoframe">Ecuador</a></li>
					<li><a href="agenda/agenda.php?country=es" target="infoframe">Espa�a</a></li>
					<li><a href="agenda/agenda.php?country=de" target="infoframe">Germany</a></li>
					<li><a href="agenda/agenda.php?country=pl" target="infoframe">Polska</a></li>
					<li><a href="agenda/agenda.php?country=ru" target="infoframe">Russia</a></li>
					<li><a href="agenda/agenda.php?country=uk" target="infoframe">United Kingdom</a></li>
				</ul>
			</div>
		</div>
	</li>
	*/
	?>
	
	<li  style="width: 60px;"><a href="party_flyers.php?country=<?php echo $country ?>" target="infoframe"><span class="imea imeam"></span>FLYERS</a></li>
	<li  style="width: 67px;"><a href="videos_artists.php" target="infoframe"><span class="imea imeam"></span>ARTISTS</a></li>
	<li  style="width: 82px;"><a href="videos.php" target="infoframe"><span class="imea imeam"></span>INTERVIEWS</a></li>
	<li  style="width: 56px;"><a href="agenda/agenda.php?country=<?php echo $country ?>" target="infoframe"><span class="imea imeam"></span>LINKS</a></li>
	<li  style="width: 58px;"><a href="javascript:menuRadio()"><span class="imea imeam"></span>RADIO</a></li>
	<li  style="width: 63px;"><a href="ctvinfo/formulario.html" target="infoframe"><span class="imea imeam"></span>CONTACT</a></li>
	
</ul>
</div>
</div><!-- menu-area -->

</div><!--  header-area -->


<div id="content-area">

   	<iframe src="<?php echo $page ?>" name="infoframe" align="middle" scrolling="auto" id="infoframe"></iframe>
   
   	<div id="ads-content">
	   	<script type="text/javascript"><!--
			google_ad_client = "pub-2653639101677884";
			google_ad_width = 468;
			google_ad_height = 60;
			google_ad_format = "468x60_as";
			google_ad_type = "text_image";
			//2007-10-29: kanaal1
			google_ad_channel = "0595031220";
			google_color_border = "000000";
			google_color_bg = "F0F0F0";
			google_color_link = "4C4C4C";
			google_color_text = "000000";
			google_color_url = "666666";
			//-->
		</script>
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
   	</div>
</div><!--  content-area -->

<div id="video-area">   

        <div id="mediadiv">
           <!-- place for the video or tv stream -->
		</div>
		
		<div id="textVideoPlaceholder">
			<span id="SpanUnderVideo">
			<!-- copyright filled in dynamically -->
			</span>
		</div>
  
  		<div id="ads-video" style="text-align: center; margin-bottom: 3px">
  			
  			<?php 
  				# put special logos for spain
  				if ($country == "es") {
  			?>
  			<div id="logoSlideShow" style="float:left;margin-left:4px; padding:0; text-align: center; vertical-align:middle">   		
  				<a href="http://www.colombianosenespana.com" target="_new"><img src="images/logos/colombianosenespanya.jpg" height="61" width="200" class="logo"></a>
 				<a href="http://www.fapatur.com" target="_new"><img src="images/logos/Fapatur.gif" height="61" width="200" class="logo"></a>
			</div>
			<?php
				} else { 
			?>  				
		   	<div id="logoSlideShow" style="float:left;margin-left:4px; padding:0; text-align: center; vertical-align:middle;height:61px;width:120px">
		   				<a href="http://www.embajadadominicana.nl" target="_new"><img src="images/logos/embajada-dominicana-120x61.jpeg" class="logo" /></a>
		   				<a href="http://mtvh.nl/" target="_new"><img src="images/logos/mtvh-logo-120x61-tran.gif" class="logo" /></a>   		
						<?php /* <a href="" target="_new"><img src="images/logos/LOGO CUCONARTE_120x61.JPG" class="logo" /></a> */ ?>
						<a href="http://www.azucar-restaurant.nl" target="_new"><img src="images/logos/LOGO-AZUCAR_120x61.jpg" class="logo" /></a>
						<?php /* <a href="http://www.ja-alles.com" target="_new"><img src="images/logos/Logo ja-alles_120x61_trans.png" class="logo" /></a> */ ?>
						<a href="http://www.chicoleo.nl" target="_new"><img src="images/logos/latin_nights2-120x61_trans.png" class="logo" /></a>
			</div>
  			<?php
				} 
			?>
   	        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" 
        		width="166" height="62">
	          <param name="movie" value="images/discograficas/discograficas.swf">
	          <param name="quality" value="high">
	          <param name="wmode" value="opaque">
	          <embed src="images/discograficas/discograficas.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="166" height="62" wmode="opaque"></embed>
	        </object>
		        
 		</div>
 					
</div><!-- video area -->

<div id="footer-main-area">


<div id="google-search">
<form action="http://www.google.nl/cse" id="cse-search-box">
  <div>
    <input type="hidden" name="cx" value="partner-pub-2653639101677884:6iu5ck-2mry" />
    <input type="hidden" name="ie" value="ISO-8859-1" />
    <input type="text" name="q" size="30" />
    <input type="submit" name="sa" value="Search" />
  </div>
</form>
<script type="text/javascript" src="http://www.google.nl/cse/brand?form=cse-search-box&amp;lang=en"></script>
</div>

</div>

<div id="disclaimer">
<!-- filled in dynamically -->
</div>

</div><!-- main-area -->

<div id="skyscraper-area">
	<!--  google skyscraper -->
	<script type="text/javascript"><!--
	google_ad_client = "pub-2653639101677884";
	/* 160x600, created 4/3/10 */
	google_ad_slot = "0839597203";
	google_ad_width = 160;
	google_ad_height = 600;
	//-->
	</script>
	<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></div>


</div><!-- outer-main-area -->

<div id="footer">
</div>                       
                       

<div id="ads">
</div>


			<script>
			
			//
			var progressx = true;
			var untilLoaded = function() {
				var p1 = $('MediaPlayer1');
				var p2 = $('MediaPlayer1Embed');
				var bufprogress, playState;
				progressx = !progressx;
				var s = (progressx?'/':'\\');
				if ($defined(p1)) {
					try {
						bufprogress = p1.network.bufferingProgress;
						playState = p1.playState;
						$('SpanUnderVideo').set('html', s+' <b>LOADING TV, BUFFERING '+bufprogress+'%</b> '+s);
						//var s="version="+p1.versionInfo;
						//s += " playstate="+p1.playState;
						//s += " buf="+p1.network.bufferingProgress;
						//$('leftcolvideo').set('html', s);
					} catch (e) {}
				}
				if ($defined(p2)) {
					try {
						bufprogress = p2.network.bufferingProgress;
						playState = p2.playState;
						$('SpanUnderVideo').set('html', s+' <b>LOADING TV, BUFFERING '+bufprogress+'%</b> '+s);
					} catch (e) {}
				}
				//playState=3: playing
				if (playState==3 && bufprogress >= 100) {
					$('SpanUnderVideo').set('html', '<a href=\"javascript:fullScreen()\">fullscreen/pantalla entera</a>&nbsp;&nbsp;&nbsp;'+COPYRIGHT_TXT);
					$clear(periodical);
				}
			};
			//var periodical = untilLoaded.periodical(500);
			// the above is only nec. when wmp live stream is used
			
			function fullScreen() {
				var p1 = $('MediaPlayer1');
				var p2 = $('MediaPlayer1Embed');
				
				if ($defined(p1)) { // IE komt hier
					try {
						// old version wmp
						//p1.DisplaySize=3;
						// new version, from wmp 7
						p1.fullScreen=true;
					} catch (e) {}
				}
				if ($defined(p2)) { //FF komt hier
					try {
						p2.fullScreen=true;
					} catch (e) {}
				}
			}
			
			</script>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-2897315-1");
pageTracker._trackPageview();
} catch(err) {}
</script>




</body>
</html>
