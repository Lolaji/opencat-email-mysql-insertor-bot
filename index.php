<?php
    require 'autoload.php';


    // $mail = new Imap();

    // if ($mail->connect('{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}INBOX', 'ayo.lolade@gmail.com', 'ayobami1')) {
    //     $inbox = $mail->getMessages('html', 'desc');
    // }

    // echo '<pre>';
    // print_r ($inbox);
    // echo '</pre>';
    
    $emailRetriever = EmailRetriever::getInstance(Config::getConfig('mail_cred/servername'), Config::getConfig('mail_cred/email'), Config::getConfig('mail_cred/password'));

    $messageNumbers = $emailRetriever->fetchMessageContent();

    echo '<pre>';
    print_r($messageNumbers);
    echo '</pre>';

    $emailRetriever->connectionClose();
?>