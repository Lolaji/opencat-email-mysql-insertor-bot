<?php

class EmailRetriever {
    
    private static $_Instance = null;
    
    private $_conn;

    private $_serverName;
    private $_username;
    private $_password;
    private $_error;
    
    private $_overview;
    private $_emailBody = '';
    private $_mailOption = array();

    public function __construct($hostName, $email, $password) {
        $this->setConfig($hostName, $email, $password);
    }

    private function _getConnection () {
        if (function_exists("imap_open")) {
            $this->_conn = imap_open('{'.$this->_serverName.'/imap/ssl}INBOX', $this->_username, $this->_password);

            if ($this->_conn == false) {
                die("Error : Failed to open connection ( ".imap_last_error()." )");
            }
        } else {
            die("Error : imap is not enable on your server. Kindly enable it in the php.ini and reload this page.");
        }
    }

    public static function getInstance ($hostName, $email, $passeord) {
        if (!isset(self::$_Instance)) {
            self::$_Instance = new EmailRetriever($hostName, $email, $passeord);
        }
        return self::$_Instance;
    }

    public function connectionClose () {
        imap_close($this->_conn);
    }

    public function getMessageNumbers () {
        $date = date ( "d M Y", strToTime ( "-1 days" ) );
        $inbox = imap_search($this->_conn, "ON \"$date\"");
        if ($inbox) {
            krsort($inbox);

            // foreach ($inbox as $email_uid) {
            //     $overview = imap_fetch_overview($this->_conn, $email_uid, 0);
            //     $message_number[] = $overview[0]->msgno;
            // }
            return $inbox;
        }
    }

    public function fetchMessageContent () {
        $messageNo = $this->getMessageNumbers();

        if ($messageNo) {
            rsort($messageNo);
            $messageContent = array();
            foreach ($messageNo as $number) {
                $messageHeaderInfo[] = imap_headerinfo($this->_conn, $number, FT_UID);
                $messageBody[] = imap_fetchbody($this->_conn, $number, 1);
            }
            return $messageHeaderInfo;
        }
    }

    public function getMessageHeaderInfo (array $messageNumber) {
        if ($messageNumber) {
            krsort($messageNumber);
            foreach ($messageNumber as $number) {
                $messageHeaderInfo[] = imap_headerinfo($this->_conn, $number, FT_UID);
            }
        }
        return $messageHeaderInfo;
    }

    public function  getErrorMessage () {
        return $this->_error;
    }

    private function _setErrorMessage ($msg) {
        $this->_error = $msg;
    }

    public function setConfig($hostName, $username, $passeord) {

        $this->_serverName  = $hostName;
        $this->_username    = $username;
        $this->_password    = $passeord;

        $this->_getConnection();
    }

}