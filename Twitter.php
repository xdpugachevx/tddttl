<?php

require_once('HttpClientInterface.php');
require_once('CacheInterface.php');

class Twitter {

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $methodUrl = 'http://api.twitter.com/1/statuses/user_timeline.json';

    /**
     * @var CacheInterface
     */
    protected $cache = null;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient) {
        $this->httpClient = $httpClient;
    }

    /**
     * @param CacheInterface $cache
     * @return Twitter
     */
    public function setCache(CacheInterface $cache) {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @param string $nickname
     * @return mixed
     */
    public function getStatuses($nickname) {
        $url = $this->methodUrl . '?screen_name=' . $nickname;

        $cache = $this->cache;
        $cacheId = md5($url);
        $data = false;


        if ($cache !== null) {
            $data = $cache->load($cacheId);
        }

        if ($data === false) {
            $data = $this->httpClient->get($url);
            if ($cache !== null) {
                $cache->save($cacheId, $data);
            }
        }

        return $data;
    }


}
