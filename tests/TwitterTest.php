<?php

require_once('../Twitter.php');

class TwitterTest extends PHPUnit_Framework_TestCase {

   public function testTwitterShouldCallHttpClientWithCorrectUrl() {
        $httpClient = $this->getMock('HttpClientInterface');
        $nickname = 'test_nick';
        $twitter = new Twitter($httpClient);

        $httpClient
                ->expects($this->once())
                ->method('get')
                ->with($this->equalTo('https://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $nickname));

        $twitter->getStatuses($nickname);
    }

    public function testTwitterShouldLoadDataFromCacheIfIsPossible() {
        $cache = $this->getMock('CacheInterface');
        $httpClient = $this->getMock('HttpClientInterface');
        $nickname = 'test_nick';
        $twitter = new Twitter($httpClient);
        $url = 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name=' . $nickname;
        $urlMd5 = md5($url);

        $resultCached = array('status1', 'status2', 'status3');
        $resultNotCached = array('save_to_cache');

        $twitter->setCache($cache);

        $cache->expects($this->at(0))->method('load')->with($this->equalTo($urlMd5))->will($this->returnValue($resultCached));

        $cache->expects($this->at(1))->method('load')->with($this->equalTo($urlMd5))->will($this->returnValue(false));
        $httpClient->expects($this->once())->method('get')->with($this->equalTo($url))->will($this->returnValue($resultNotCached));
        $cache->expects($this->once())->method('save')->with($this->equalTo($urlMd5), $this->equalTo($resultNotCached));

        $this->assertEquals($resultCached, $twitter->getStatuses($nickname));
        $this->assertEquals($resultNotCached, $twitter->getStatuses($nickname));
    }

}