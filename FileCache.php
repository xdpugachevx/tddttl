<?php

require_once('CacheInterface.php');

class FileCache implements CacheInterface {

    protected $cacheDir;

    protected $lifetime;

    public function __construct($cacheDir = '.', $lifetime = 3600) {
        $this->cacheDir = $cacheDir;
        $this->lifetime = $lifetime;
    }

    public function save($id, $data) {
        $filename = $this->_createFilename($id);

        $f = fopen($filename, 'w');
        fwrite($f, $data);
        fclose($f);
    }

    public function load($id) {
        $filename = $this->_createFilename($id);

        if (!file_exists($filename)) {
            return false;
        }

        if (time() - fileatime($filename) > $this->lifetime) {
            return false;
        }

        return file_get_contents($filename);
    }


    protected function _createFilename($id) {
        return $this->cacheDir . '/' . $id . '.dat';
    }

}