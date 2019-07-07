<?php /** @noinspection PhpUnhandledExceptionInspection */
# htaccess ---> admin:87226113

// Send dunning emails:
#echo dunning();
echo '
<html>
    <head>
        <meta name="robots" content="noindex, nofollow">
        <link href="../css/default.min.css" type="text/css" rel="stylesheet">
    </head>
<body>';

require_once 'sitemapper.php';

// DKB Crawler
echo '<strong>Execute DKB Crawler</strong><br />';
require_once '../libs/DKB/dkb-crawl.php';




echo '
</body>
</html>';