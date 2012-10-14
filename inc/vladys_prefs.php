<?php

# supported countries can be used in url as follow: index.php?country=es
# country should have at least agenda page and may also have specific flyers, playlist and banners
# country automatic redirection (e.g. www.caribe-tv.com/es) is handled completely separated by apache .htaccess file. 
$SUPPORTED_COUNTRIES = array("nl", "ar", "dk","ch","an", "it","ca", "ec", "ch", "in", "be", "pl", "de","pr", "ru", "es", "uk", "co", "fr", "mx", "sr", "us", "lu", "jp", "ca", "br", "ve", "ro");

# if START_WITH_YOUTUBE_PLAYLIST = true then we start with playlist and the individual video is ignored. 
# The playlist title and url should be set.
# if START_WITH_YOUTUBE_PLAYLIST = false then the individual video should be set with YOUTUBE_VIDEO_ID
$START_WITH_YOUTUBE_PLAYLIST = true;

# $YOUTUBE_PLAYLIST_TITLE = 'Turismo Latino';
$YOUTUBE_PLAYLIST_TITLE = 'Total Salsa Agenda';
# $YOUTUBE_PLAYLIST_URL = 'http://www.youtube.com/p/698249E230E3009D';
$YOUTUBE_PLAYLIST_URL = 'http://www.youtube.com/playlist?list=PL5C4F0B6BDCAC5B99';

# the above is the default. Below is per country...
${YOUTUBE_PLAYLIST_TITLE.uk} = 'CARIBE-TV EN UK'; 
${YOUTUBE_PLAYLIST_URL.uk} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.be} = 'CARIBE-TV EN BELGICA';
${YOUTUBE_PLAYLIST_URL.be} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.ca} = 'CARIBE-TV EN CANADA';
${YOUTUBE_PLAYLIST_URL.ca} = 'http://www.youtube.com/p/6FEC97997919EE8C';

${YOUTUBE_PLAYLIST_TITLE.lu} = 'CARIBE-TV EN LUXEMBURGO';
${YOUTUBE_PLAYLIST_URL.lu} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.dk} = 'CARIBE-TV EN DINAMARCA';
${YOUTUBE_PLAYLIST_URL.dk} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.an} = 'CARIBE-TV EN LAS ANTILLAS';
${YOUTUBE_PLAYLIST_URL.an} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.ar} = 'CARIBE-TV EN ARGENTINA';
${YOUTUBE_PLAYLIST_URL.ar} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.de} = 'CARIBE-TV EN ALEMANIA';
${YOUTUBE_PLAYLIST_URL.de} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.it} = 'CARIBE-TV EN ITALIA';
${YOUTUBE_PLAYLIST_URL.it} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.es} = 'CARIBE-TV EN ESPA�A';
${YOUTUBE_PLAYLIST_URL.es} = 'http://www.youtube.com/p/9A096B85D0902C60';

#${YOUTUBE_PLAYLIST_TITLE.nl} = 'Turismo Latino - Holanda';
${YOUTUBE_PLAYLIST_URL.nl} = 'http://www.youtube.com/p/698249E230E3009D';
${YOUTUBE_PLAYLIST_TITLE.nl} = 'Total Salsa Agenda - Holanda';
#${YOUTUBE_PLAYLIST_URL.nl} = 'http://www.youtube.com/playlist?list=PL5C4F0B6BDCAC5B99';

${YOUTUBE_PLAYLIST_TITLE.fr} = 'CARIBE-TV EN FRANCIA';
${YOUTUBE_PLAYLIST_URL.fr} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.mx} = 'CARIBE-TV EN MEXICO';
${YOUTUBE_PLAYLIST_URL.mx} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.pr} = 'CARIBE-TV EN PUERTO RICO';
${YOUTUBE_PLAYLIST_URL.pr} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.sr} = 'CARIBE-TV EN SURINAM';
${YOUTUBE_PLAYLIST_URL.sr} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.ch} = 'CARIBE-TV EN SUIZA';
${YOUTUBE_PLAYLIST_URL.ch} = 'http://www.youtube.com/p/77320F8B8FBA3E65';

${YOUTUBE_PLAYLIST_TITLE.us} = 'CARIBE-TV EN USA';
${YOUTUBE_PLAYLIST_URL.us} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.in} = 'CARIBE-TV EN INDIA';
${YOUTUBE_PLAYLIST_URL.in} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.co} = 'CARIBE-TV EN COLOMBIA';
${YOUTUBE_PLAYLIST_URL.co} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.jp} = 'CARIBE-TV EN JAPON';
${YOUTUBE_PLAYLIST_URL.jp} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.br} = 'CARIBE-TV EN BRASIL';
${YOUTUBE_PLAYLIST_URL.br} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.ve} = 'CARIBE-TV EN VENEZUELA';
${YOUTUBE_PLAYLIST_URL.ve} = 'http://www.youtube.com/p/864E4AA00D836EA2';

${YOUTUBE_PLAYLIST_TITLE.ro} = 'CARIBE-TV EN RUMANIA';
${YOUTUBE_PLAYLIST_URL.ro} = 'http://www.youtube.com/p/864E4AA00D836EA2';

# youtube video id for starting video
# if the video url is e.g. http://www.youtube.com/watch?v=4Ltm1QH2npo&feature=related
# then the video id = 4Ltm1QH2npo
# some videos are: eXHtnoen6XY, Ma8ZBuM-_4E, NNi8PZdvKg0, YXe8JiarpXU
 
$YOUTUBE_VIDEO_ID = 'dMjqh3fIXWc';
# $YOUTUBE_VIDEO_ID = '-uOywQHdS08';
?>



