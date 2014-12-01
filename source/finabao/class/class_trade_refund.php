<?php

class TradeRefund
{
    protected $_uid       =   0;
    protected $_order     =   '';
    protected $_type      =   '';
    protected $_money     =   0;
    protected $_min       =   '10';
    protected $_bank      =   array();
    protected $_max       =   '200000';
    protected $_factor    =   'field1';
    protected $_settle    =   '';
    protected $_setable   =   '';

    public function __construct($uid, $money, $type, $bankid)
    {
        $this->_uid     =   $uid;
        $this->_order   =   $this->creadeOrder();
        $this->_money   =   finanum($money);
        $this->_type    =   $type;
        $this->_bank    =   $this->verifybank($bankid);

        finaload('class/trade_settle');
        $settle  =   new TradeSettle();
        $this->_settle  =   $settle->settle($this->_uid);
        $this->_setable =   $settle->_setable;
    }
    /**
     * 创建订单号
     */
    public function creadeOrder()
    {
        // yymmddhhiiss(12)+pp(2)+999(6) = 20
        return date("ymdHis").'99'.random(6, 1);
    }

    public function verifymoney()
    {

        if($this->_money < $this->_min) showmessage('每笔提现金额不能小于 '.$this->_min.' 元');
        if($this->_money > $this->_max) showmessage('每笔提现金额不能大于 '.$this->_max.' 元');
        //debug($this->_money);
        return $this->_money > $this->_settle['usable'] ? showmessage('提现金额已经超过了您的可用余额.') : $this->_settle['usable'];
    }

    public function verifybank($bankid)
    {
        return DB::fetch_first("SELECT * FROM %t WHERE uid=%d AND id=%d", array('plugin_finabao_cards', $this->_uid, $bankid));
    }

    public function saveOrder()
    {
        self::verifymoney();
        if(!is_array($this->_bank)) showmessage('没有找到您的银行卡信息', dreferer());
        $retype     =   $_G[APP_NAME]['cache']['retype'];

        if($this->_type == 'donow'){
            $predictime =   TIMESTAMP + 7200;


        } elseif($this->_type == 'fast') {
            $predictime =   dmktime(gmdate('Y-m-d', TIMESTAMP+(3600*8))) + 3600*36;
        } else {
            $predictime =   dmktime(gmdate('Y-m-d', TIMESTAMP+(3600*8)))+3600*36 + $retype[$this->_type]['limitime']*86400;
        }

        $data = array(
            'trade'     =>  $this->_order,
            'uid'       =>  $this->_uid,
            'type'      =>  $this->_type,
            'money'     =>  $this->_money,
            'deal'      =>  $this->_money - $this->_money*$this->compute($this->_type)/10000,
            'rate'      =>  $this->compute($this->_type),
            'factorage' =>  $this->_money*$this->compute($this->_type)/10000,
            'dateline'  =>  TIMESTAMP,
            'predictime'    =>  $predictime,
            'rebank'    =>  authcode(serialize($this->_bank), 'ENCODE', $this->_order),
            'remark'    =>  '客户自助提现结算'
        );

        $this->freeze($this->_order);
        $this->_type == 'donow' ? self::SMSWarn($this->_order, DB::result_first("SELECT username FROM %t WHERE uid=%d", array('common_member', $this->_uid)), $this->_money) : '';
        return DB::insert('plugin_finabao_trade_refund', $data) ? $data : false;
    }

    public function compute($type)
    {
        global $_G;
        $factorage  =   DB::fetch_first("SELECT * FROM %t WHERE uid=%d", array('common_member_profile', $this->_uid));
        $retype     =   finacache('plugin_finabao_trade_retype', 'finabao_retype', 'retype');;

        if($type == 'donow' || $type == 'fast') {
            return  $factorage[$this->_factor] ? $factorage[$this->_factor] : $retype[$type]['factorage'];
        } else {
            return  $retype[$type]['factorage'];
        }

    }

    protected function freeze($order)
    {
        $this->verifymoney();

        $member =   DB::fetch_first("SELECT * FROM %t WHERE uid=%d", array('common_member', $this->_uid));
        $data   =   array(
            'uid'       => $member['uid'],
            'username'  => $member['username'],
            'trade'     => $order,
            'type'      => 'freeze',
            'freeze'    => 1,
            'money'     => $this->_money,
            'dateline'  => TIMESTAMP
        );

        $data['md5hash']    =   md5(serialize($data));
        $data['auth']       =   authcode(serialize($data), 'ENCODE', $this->_order);

        return DB::insert($this->_setable, $data);
    }

    protected function SMSWarn($trade, $username, $money)
    {
        global $_G;
        $msg    =   '一个加急订单已提交，单号：{trade}，用户：{username},金额：{money}，请及时处理！';
        $sitevars = array(
            '{username}'    => $username,
            '{trade}'       => $trade,
            '{money}'       => $money
        );
        $send    =   str_replace(array_keys($sitevars), array_values($sitevars), $msg);


        // 解智强
        SMSFund('SMSCenter', '15887920236', $send, 'refund');

        // 徐力
        SMSFund('SMSender', '18687444499', $send, 'refund');

        // 岳悦
        SMSFund('SMSender', '13278797771', $send, 'refund');

        // 高钦
        SMSFund('SMSCenter', '15198956943', $send, 'refund');

    }

}

?>