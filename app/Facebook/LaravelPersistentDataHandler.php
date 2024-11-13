<?php

namespace App\Facebook;

use Facebook\PersistentData\PersistentDataInterface;

class LaravelPersistentDataHandler implements PersistentDataInterface
{
    protected $sessionPrefix = 'FBRLH_';

    public function get($key)
    {
        return session($this->sessionPrefix . $key);
    }

    public function set($key, $value)
    {
        session([$this->sessionPrefix . $key => $value]);
    }
}
