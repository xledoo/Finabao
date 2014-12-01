<?php


class BankCrad
{
    var $_uid       =   0;
    var $_field     =   'field8';
    var $_banks     =   array();
    var $_max       =   5;

    public function __construct($uid)
    {
		global $_G;
        $this->_uid     =   $uid;
        $this->_banks   =   $_G[APP_NAME]['cache']['banks'];
    }

    /**
     * 获取当前银行卡列表
     */
    public function query()
    {
        return $bankcards  =   DB::fetch_all("SELECT * FROM %t WHERE uid=%d AND type='0'", array('plugin_finabao_cards', $this->_uid));
    }

    public function add($code, $username, $cardid, $open)
    {

        if(!$this->_banks[$code]) return false;
        if(strlen($username) > 12 || strlen($username) < 2) showmessage('请填写正确的户名', dreferer());
        if(self::check($cardid)) showmessage('该卡已经添加过了哦！', dreferer());

        if(!preg_match('/^[0-9]+$/i', $cardid) || strlen($cardid) > 25 || strlen($cardid) < 10) showmessage('请填写正确的银行卡号', dreferer());

        $data   =   array(
                'uid'       =>  $this->_uid,
                'cardname'  =>  daddslashes($username),
                'cardid'    =>  trim($cardid),
                'banksign'  =>  $code,
                'openaddr'  =>  daddslashes($open),
                'dateline'  =>  TIMESTAMP
            );
        DB::insert('plugin_finabao_cards', $data);
    }

    public function check($card)
    {
        return DB::result_first("SELECT cardid FROM %t WHERE cardid=%s", array('plugin_finabao_cards', $card));
    }

    public function del($k)
    {

    }

}


?>