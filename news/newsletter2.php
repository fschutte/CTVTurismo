<?php
/* Gebruikt de mailinglist mogelijkheden van poplist.fr (swisstools) */
?>

<html>
<head>
<title>Newsletter</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="newsletter.css" rel="stylesheet" type="text/css" />

		<script src="../js/mootools-1.2.5-core-yc.js" type="text/javascript"></script> 
		<script src="../js/mootools-1.2.5.1-more.js" type="text/javascript"></script>

</head>

<body>
<h3>CaribeTV Club Newsletter:</h3>
<p>
<span class="es">Ponga su email para abonarte o Desabonarte.</span><br>
<span class="en">Put in your email to subscribe or unsubscribe</span>
</p>

<FORM ACTION="http://www.poplist.fr/sub_unsub.php" target="_blank" METHOD="post">
<INPUT TYPE="HIDDEN" Name="lid" Value="">
<table width="140" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
<tr><td>Your email :</td></tr>
<tr><td><input name="email" type="text" size="20"></td></tr>
<tr><td><input type="radio" name="action" value="subscribe"> Subscribe</td></tr>
<tr><td><input type="radio" name="action" value="unsubscribe"> Cancel subscription</td></tr>
<tr><td><input name="envoyer" type="submit" value="Validate"></td>
</tr>
</table>
</FORM>


</body>
</html>
