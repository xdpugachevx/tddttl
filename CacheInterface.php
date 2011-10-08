<?php

interface CacheInterface {
    /**
     * @abstract
     * @param string $id
     * @param mixed $data
     * @return bool
     */
    public function save($id, $data);

    /**
     * @abstract
     * @param string $id
     * @return mixed
     */
    public function load($id);
}
