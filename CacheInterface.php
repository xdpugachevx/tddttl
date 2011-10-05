<?php

interface CacheInterface {
    public function save($id, $data);

    public function load($id);
}
