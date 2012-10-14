<?php
	
	include_once('vladys_prefs.php');

  /**
   * See http://www.tutorialized.com/tutorials/PHP/Redirection/1
   * 
   * Original code from svn://hostip.info/hostip/api/trunk. Optimized & enhanced by Quang Pham @ Saoma, 06.01.07.
   */   
  function isPrivateIP($ip) {
    list($a, $b, $c, $d) = sscanf($ip, "%d.%d.%d.%d");
    return  $a === null || $b === null || $c === null || $d === null ||
            $a == 10    ||
            $a == 239   ||
            $a == 0     ||
            $a == 127   ||
           ($a == 172 && $b >= 16 && $b <= 31) ||
           ($a == 192 && $b == 168);
  }   
   
  function getVisitorIP() {
    $default = false;
    
    if (isset($_SERVER)) {
      $default_ip = $_SERVER["REMOTE_ADDR"];      
      $xforwarded_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
      $client_ip = $_SERVER["HTTP_CLIENT_IP"];    
    } else {
      $default_ip = getenv('REMOTE_ADDR');
      $xforwarded_ip = getenv('HTTP_X_FORWARDED_FOR');
      $client_ip = getenv('HTTP_CLIENT_IP');
    }
    
    if ($xforwarded_ip != "") {
      $result = $xforwarded_ip;
    } else if ($client_ip != "") {
      $result = $client_ip;
    } else {
      $default = true;
    }
    
    if (!$default) { // additional check for private ip numbers 
      $default = isPrivateIP($result);
    }
    
    if ($default) {
      $result = $default_ip;
    }
    
    return $result;
  }
  
  function getVisitorCountry() {
  		$ip = getVisitorIP();
  		return getVisitorCountryByIP($ip);
   }

  function getVisitorCountryByIP($ip) {
    // make a valid request to the hostip.info API  
    $url = "http://api.hostip.info/country.php?ip=".$ip;
  	// fetch with curl
    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    $country = curl_exec($ch);
  
    curl_close ($ch);
  
    $lwcountry = strtolower($country);
    
    return $lwcountry;
  }
  
  
  //FS: use this function everywhere
  function determineCountry() {
	  global $SUPPORTED_COUNTRIES;

  		$DEFAULT_SUPPORTED_COUNTRIES = array("nl", "ar", "ch", "it", "ec", "be", "pl", "de", "ru", "es", "uk", "co");

		if (!isset($SUPPORTED_COUNTRIES)) $SUPPORTED_COUNTRIES = $DEFAULT_SUPPORTED_COUNTRIES;
		
		# first check if page was called with parameter country
		if ($_GET["country"]) 
			$c = $_GET["country"];
		# second check the country of the visitor (glocalizationutil)
		else {
		   	$c = getVisitorCountry();
		}
		$c = strtolower($c);

		// default to nl if country was unknown	        
		if (in_array($c, $SUPPORTED_COUNTRIES)) {
		    $country = $c;
		} else {
		    $country = "nl";
		}
  		return $country;
  }

?>
