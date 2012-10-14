<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
include_once('inc/vladys_prefs.php');
include_once('inc/glocalizationutil.php');

$country = determineCountry();      

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Caribe TV Flyers</title>
		
		
		<link rel="stylesheet" href="thirdparty/SmoothGallery-2.1/css/layout.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="thirdparty/SmoothGallery-2.1/css/jd.gallery.css" type="text/css" media="screen" charset="utf-8" />
		
		
	 	
		<script src="js/mootools-1.2.5-core-nc.js" type="text/javascript"></script> 
		<script src="js/mootools-1.2.5.1-more.js" type="text/javascript"></script>
		
		<script src="thirdparty/SmoothGallery-2.1/scripts/jd.gallery.js" type="text/javascript"></script>
		<script src="thirdparty/SmoothGallery-2.1/scripts/jd.gallery.set.js" type="text/javascript"></script>
		
	 	
	<style>
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
		
		<style type="text/css">
			#myGallery {
				width: 400px !important;
				height: 315px !important;
			}
		</style>		
	</head>
	<body>
		<script type="text/javascript">
			var framed = false; // of we los draaien of in een ingeframed zijn
			
			function startGallery() {
				framed = (top.location != document.location);
				
				var myGallery = new gallery($('myGallery'), {
					timed: true,
					delay: 3000,
					showArrows: true,
					showCarousel: true,
					textShowCarousel: 'Flyers',
					showInfopane: false,
					embedLinks: true,
					useThumbGenerator: false
					
				});
				
				var options = "";
				var linksMap = function(el) {
					// return [el.getPrevious("a").href, el.title]
					var t = el.getStyle("background-image");
					var url = t.replace(/^url\(\"(.*)\.small(.*)\"\)$/, "$1$2");
					return [url, el.title]
				}
				//$$("#myGallery .imageElement img.full").slimbox(options, linksMap);
				
//				$$(".slideElement").slimbox(options, linksMap);
				
			}
			window.addEvent('domready',startGallery);
			
			// deze wordt aangeroepen als je op de image drukt. Het idee is dat de grote variant op het scherm verschijnt.
			//  middels de onImageLoad wordt de daadwerkelijke grootte bepaald
			function openImage(url) {			
				if (framed) top.openImage(url);	
				else {
					$('myImage').setProperty('src', url);
				}
			}
			
			function closeImage() {
				if (framed) top.closeImage();	
				else {
					document.getElementById('light').style.display='none';
					document.getElementById('fade').style.display='none';
				}
			}
			
			function onImageLoad() {
				if (framed) top.openImage(url);	
				else {
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
			}
		</script>
		
		<div id="light" class="white_content"><a href="javascript:void(0)" onclick="closeImage()"><img id="myImage" onload="onImageLoad()" style="height:100%; margin:0; padding:0; border:0"/></a></div>
		<div id="fade" class="black_overlay" onclick="closeImage()"></div>
				
		<div class="content">
			<div id="myGallery">
			
		<?php
			// NOTE: the folder needs to be writeable.  At Infomaniak hoster, the default is not public writeable. You should change this
			// with an ftp client or so!!   Note also the country specific folders.
			$flyersFolder = "flyers";  //default folder
			
			// if country param exists and if there is a special flyers folder for this country then use that folder (e.g. flyers_uk)
	       	$potentialFolder = $flyersFolder . "_" . $country;
	       	if (is_dir($potentialFolder)) $flyersFolder = $potentialFolder;

		echo "\n<!-- country=$country  flyers=$flyersFolder -->\n";	

			processFolder($flyersFolder);
			
			//------------------
		
		// all .png and .jpg files within the folder are resized if needed (both thumbnail size and small size	
		function processFolder($dir) {
			$pattern="/(.*)((\.jpg$)|(\.png$))/i"; //valid image extensions
			$files = array();
			
			if ($handle = opendir($dir)) {
				echo "\n<!-- opendir $dir-->\n";
				$curimage = 0;
				while (false !== ($file = readdir($handle))){
					echo "\n<!--file = $file -->";
					//if (eregi($pattern, $file, $regs)){ //if this file is a valid image
					// FS20120523 eregi is deprecated in php 5.3 (webreus totalsalsaagenda slikt dit niet)
					if (preg_match($pattern, $file, $regs)){ //if this file is a valid image

						$basefile = $regs[1];
						$extension = $regs[2];   
						
						// only handle original images, no the small images and thumbnails
						if (substr($basefile, -6) != '.small' && substr($basefile, -6) != '.thumb') {
						
							$smallfile = $basefile.'.small'.$extension;
							$thumbfile = $basefile.'.thumb'.$extension;
													
							if (!file_exists($dir.'/'.$smallfile)) {
								$origImage = open_image($dir.'/'.$file);						
								$resizedImage = resizeimageXMaxY($origImage, 400, 300);
								
								// save file
								if ($extension == "jpg") {
									$jpegquality = 95;
									imagejpeg($resizedImage, $dir.'/'.$smallfile, 95);
								} else {
									imagepng($resizedImage, $dir.'/'.$smallfile);
								}
							}
							
							if (!file_exists($dir.'/'.$thumbfile)) {
								$origImage = open_image($dir.'/'.$file);						
								$resizedImage = resizeimageXY($origImage, 100, 75);
								
								// save file
								if ($extension == "jpg") {
									$jpegquality = 95;
									imagejpeg($resizedImage, $dir.'/'.$thumbfile, 95);
								} else {
									imagepng($resizedImage, $dir.'/'.$thumbfile);
								}
							}
							
							
							print '
							<div class="imageElement">
							   <h3>Image '.++$curimage.'</h3><p></p>
							   <a href="javascript:openImage(\''.$dir.'/'.$file.'\')" title="open image" class="open"></a>
							   <img src="'.$dir.'/'.$smallfile.'" class="full" title="party flyer"/>
							   <img src="'.$dir.'/'.$thumbfile.'" class="thumbnail" />
							</div>
							';
						}
					}
				}
				closedir($handle);
			}
		}
		?> 
		
			</div>	
		</div>
	</body>
</html>


<?php
function resizeimagePerc($image, $perc) {
    $width = imagesx($image);
    $height = imagesy($image);
	$percent = $percent/100;
    $new_width = $width * $percent;
    $new_height = $height * $percent;
	return resizeimage($image, $width, $height, $new_width, $new_height);
}
function resizeimageY($image, $new_height) {
    $width = imagesx($image);
    $height = imagesy($image);
    $new_width = $width * ($new_height/$height);
    $new_height = $height;
    return resizeimage($image, $width, $height, $new_width, $new_height);
}
function resizeimageX($image, $new_width) {
    $width = imagesx($image);
    $height = imagesy($image);
    $new_width = $width;
    $new_height = $height * ($new_width/$width);
	return resizeimage($image, $width, $height, $new_width, $new_height);
}
// resize to width, but take a maximum of Y into account
function resizeimageXMaxY($image, $proposed_width, $max_height) {
    $width = imagesx($image);
    $height = imagesy($image);
    $proposed_height = $height * ($proposed_width/$width);
    if ($proposed_height > $max_height) {
    	$new_height = $max_height;
    	$new_width = $width * ($new_height/$height);
    } else {
    	$new_height = $proposed_height;
    	$new_width = $proposed_width;
    }
    return resizeimage($image, $width, $height, $new_width, $new_height);
}
// resize to height, but take a maximum of X into account
function resizeimageYMaxX($image, $proposed_height, $max_width) {
    $width = imagesx($image);
    $height = imagesy($image);
    $proposed_width = $width * ($proposed_height/$height);
    if ($proposed_width > $max_width) {
    	$new_width = $max_width;
    	$new_height = $height * ($new_width/$width);
    } else {
    	$new_width = $proposed_width;
    	$new_height = $proposed_height;
    }
    return resizeimage($image, $width, $height, $new_width, $new_height);
}

function resizeimageXY($image, $new_width, $new_height) {
    $width = imagesx($image);
    $height = imagesy($image);
	return resizeimage($image, $width, $height, $new_width, $new_height);
}
function resizeimage($image, $width, $height, $new_width, $new_height) {
	// Resample
    $image_resized = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	return $image_resized;
}


function open_image ($file) {

    # JPEG:
    $im = @imagecreatefromjpeg($file);
    if ($im !== false) { return $im; }

    # PNG:
    $im = @imagecreatefrompng($file);
    if ($im !== false) { return $im; }

    # GIF:
    $im = @imagecreatefromgif($file);
    if ($im !== false) { return $im; }

    # GD File:
    $im = @imagecreatefromgd($file);
    if ($im !== false) { return $im; }

    # GD2 File:
    $im = @imagecreatefromgd2($file);
    if ($im !== false) { return $im; }

    # WBMP:
    $im = @imagecreatefromwbmp($file);
    if ($im !== false) { return $im; }

    # XBM:
    $im = @imagecreatefromxbm($file);
    if ($im !== false) { return $im; }

    # XPM:
    $im = @imagecreatefromxpm($file);
    if ($im !== false) { return $im; }

    # Try and load from string:
    $im = @imagecreatefromstring(file_get_contents($file));
    if ($im !== false) { return $im; }

    return false;
}
?> 
