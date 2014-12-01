<?php


/**
*发送手机短信
*/
class SMSender
{

    var $_username;
    var $_password;
    var $_charset;
    var $_interface;


    function __construct($username, $password, $charset, $interface)
    {
        $this->_username    =   $username;
        $this->_password    =   $password;
        $this->_charset     =   $charset;
        $this->_interface   =   $interface;
    }

    function SendSMS($mobile, $message, $action = ''){
        global $_G;

        $sitevars = array(
            '{username}'    => $this->_username,
            '{password}'    => $this->_password,
            '{charset}'     => $this->_charset,
            '{mobile}'      => $mobile,
            '{message}'     => urlencode($message)
        );
        $sendapi    =   str_replace(array_keys($sitevars), array_values($sitevars), $this->_interface);

        $fp         =   fopen($sendapi, "r");
        $result     =   fread($fp, 512);
        fclose($fp);

        finaload('class/xml');

        $redata       =     xml2array($result, true);
        $status       =     $redata['result'] > 0 ? 1 : 0;

        DB::insert('plugin_finabao_smsender', array('sendip' => $_G['clientip'], 'mobile' => $mobile, 'message' => daddslashes($message), 'action' => $action, 'dateline' => $_G['timestamp'], 'status' => $status, 'result' => daddslashes($result)));

        return $redata['result'] > 0 ? true : false;
    }
}



?>