<?php
// error_reporting(0);
set_time_limit(300);

$GLOBALS['emailRetrieverConfig'] = array (
    'mail_cred' => array (
        'email'         => 'idesignuxservice@gmail.com',
        'password'      => 'Temitayo1',
        'servername'   => 'imap.gmail.com:993'
    )
);

spl_autoload_register(function($class){
    require_once 'lib/'. $class .'.php';
});