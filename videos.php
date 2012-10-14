<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Videos from YouTube</title>
<script src="js/mootools-1.2-core-yc.js" type="text/javascript"></script>

<style>
.videoList {
	width: 420px;
}
.videoList a {
	font-size: 12px;
	font-family: arial;
}
.videoList .videoDescription {
	font-size: 10px;
	font-family: arial;
}
.videoList img {
	width:180px
}

body {
	background-image:url("images/bg-light900x500.jpg");
	background-position:center center;
	background-repeat:no-repeat;
	background-attachment:fixed;
}

</style>

</head>
<body>


<?php

/**
 * @see Zend_Loader
 */
require_once 'Zend/Loader.php';

/**
 * @see Zend_Gdata_YouTube
 */
Zend_Loader::loadClass('Zend_Gdata_YouTube');

getAndPrintUserUploads('LatinTelevision');

function getAndPrintUserUploads($userName) {     
  $yt = new Zend_Gdata_YouTube();
  echoVideoList($yt->getuserUploads($userName));
} 

/**
 * Finds the URL for the flash representation of the specified video
 *
 * @param  Zend_Gdata_YouTube_VideoEntry $entry The video entry
 * @return string|null The URL or null, if the URL is not found
 */
function findFlashUrl($entry) 
{
    foreach ($entry->mediaGroup->content as $content) {
        if ($content->type === 'application/x-shockwave-flash') {
            return $content->url;
        }
    }
    return null;
}

/**
 * Echo the list of videos in the specified feed.
 *
 * @param  Zend_Gdata_YouTube_VideoFeed $feed The video feed
 * @return void
 */
function echoVideoList($feed) 
{
    echo '<table class="videoList">';
    echo '<tbody width="100%">';
    foreach ($feed as $entry) {
        $videoId = $entry->getVideoId();
        $thumbnailUrl = $entry->mediaGroup->thumbnail[0]->url;
        $videoTitle = $entry->mediaGroup->title;
        $escVideoTitle = addslashes($videoTitle);
        $videoDescription = $entry->mediaGroup->description;
        $videoUrl = findFlashUrl($entry);
        print <<<END
        <tr onclick="updateVideo('${escVideoTitle}','${videoUrl}')" valign="top">
        <td width="130"><img src="${thumbnailUrl}" /></td>
        <td width="100%">
        <a href="#">${videoTitle}</a>
        <p class="videoDescription">${videoDescription}</p>
        </td>
        </tr>
END;
    }
    echo '</table>';
    
}

?>

<script>
function updateVideo(videoTitle, videoUrl) {
	parent.updateVideo(videoTitle, videoUrl);
}
</script>

</body>
</html>
