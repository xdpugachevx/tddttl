<?php

require_once('../FileCache.php');
 
class FileCacheTest extends PHPUnit_Framework_TestCase {

    protected $cacheDir = './cache_data';

    protected function setUp() {
        //Create cache dir
        if (file_exists($this->cacheDir)) {
            $this->_removeCacheDir();
        }
        mkdir($this->cacheDir);
    }

    public function tearDown() {
        //remove cache dir
        $this->_removeCacheDir();
    }

    protected function _removeCacheDir() {
        $dir = opendir($this->cacheDir);
        if ($dir) {
            while ($file = readdir($dir)) {
                if ($file != '.' && $file != '..') {
                    unlink($this->cacheDir . '/' . $file);
                }
            }
        }
        closedir($dir);
        rmdir($this->cacheDir);
    }

    public function testFileCacheClassShouldImplementCacheInterface() {
        $fileCache = new FileCache();

        $this->assertInstanceOf('CacheInterface', $fileCache);
    }

    public function testSettingCacheDir() {
        $beforeFilesCount = count(scandir($this->cacheDir));

        $fileCache = new FileCache($this->cacheDir);

        $fileCache->save('data_name', 'some data');

        $afterFilesCount = count(scandir($this->cacheDir));

        $this->assertTrue($afterFilesCount > $beforeFilesCount);
    }

    public function testSettingCacheLifetime() {
        $lifetime = 2;

        $cacheData = 'data';
        $cacheId = 'expires';

        $fileCache = new FileCache($this->cacheDir, $lifetime);

        $fileCache->save($cacheId, $cacheData);

        $this->assertEquals($cacheData, $fileCache->load($cacheId));

        sleep(3);

        $this->assertFalse($fileCache->load($cacheId));
    }

    public function testLoadShouldReturnFalseOnNonexistId() {
        $fileCache = new FileCache($this->cacheDir);

        $fileCache->save('id', 'some data');

        $this->assertFalse($fileCache->load('non_exist'));
    }



}
