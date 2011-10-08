<?php

/**
 * @author Denis Pugachev <xstupidkidzx@gmail.com>
 */

interface HttpClientInterface {
    /**
     * @abstract
     * @param string $url
     * @return string
     */
    public function get($url);
}
