<?php

class Config {
    public static function getConfig ($path=null) {
        if ($path) {
            $config = $GLOBALS['emailRetrieverConfig'];
            $path = explode('/', $path);
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
    }
}