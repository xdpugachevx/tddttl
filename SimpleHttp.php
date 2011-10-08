<?php

/**
 * @author Denis Pugachev <xstupidkidzx@gmail.com>
 */

require_once('HttpClientInterface.php');

class SimpleHttp implements HttpClientInterface {
    /**
     * @param string $url
     * @return string
     */
    public function get($url) {
        return file_get_contents($url);
    }
}
