<?php

require_once('FileCache.php');
require_once('Twitter.php');
require_once('SimpleHttp.php');

$simpleHttp = new SimpleHttp();
$fileCache = new FileCache('cache');
$twitter = new Twitter($simpleHttp);
$twitter->setCache($fileCache);

echo $twitter->getStatuses('twitter');