<?php

/**
 * @author Denis Pugachev <xstupidkidzx@gmail.com>
 */

require_once('CacheInterface.php');

class FileCache implements CacheInterface {

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var int
     */
    protected $lifetime;

    /**
     * @param string $cacheDir
     * @param int $lifetime
     */
    public function __construct($cacheDir = '.', $lifetime = 3600) {
        $this->cacheDir = $cacheDir;
        $this->lifetime = $lifetime;
    }

    /**
     * @param string $id
     * @param mixed $data
     * @return bool
     */
    public function save($id, $data) {
        $filename = $this->_createFilename($id);

        $f = fopen($filename, 'w');
        fwrite($f, serialize($data));
        fclose($f);

        return true;
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function load($id) {
        $filename = $this->_createFilename($id);

        if (!file_exists($filename)) {
            return false;
        }

        if (time() - fileatime($filename) > $this->lifetime) {
            return false;
        }

        return unserialize(file_get_contents($filename));
    }


    protected function _createFilename($id) {
        return $this->cacheDir . '/' . $id . '.dat';
    }

}