<!DOCTYPE html>
<html>
	<head>
		<title>Test youtube</title>		
	</head>
	<body>
		Er is een nieuwe manier om youtube playlists te includen in een pagina.
		Oude manier:
		
		<div id="mediadiv">
			<b>CARIBE-TV EN HOLANDA</b><br>
			<object height="300" width="390">
				<param name="movie" value="http://www.youtube.com/p/3A850F1E8CAF331B&amp;autoplay=1&amp;fs=1">
				<param name="wmode" value="transparent">
				<param name="allowFullScreen" value="true">
				<embed src="http://www.youtube.com/p/3A850F1E8CAF331B&amp;autoplay=1&amp;fs=1" 
					type="application/x-shockwave-flash" 
					wmode="transparent" 
					allowfullscreen="true" 
					height="300" 
					width="390&quot;">
			</object>
		</div>
		
		<hr>
		Nieuwe manier is om gebruik te maken van een iframe. 
		Op deze manier kan Youtube zelf ervoor zorgen dat er een html5 video komt ipv alles met flash te streamen.
		
		<iframe 
			width="390" height="300" 
			src="http://www.youtube.com/embed/videoseries?list=PL5C4F0B6BDCAC5B99&amp;hl=en_US" 
			frameborder="0" 
			allowfullscreen>
		</iframe>
		
		
	</body>
</html>