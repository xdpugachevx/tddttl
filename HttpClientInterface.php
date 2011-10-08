<?php

interface HttpClientInterface {
    /**
     * @abstract
     * @param string $url
     * @return string
     */
    public function get($url);
}
