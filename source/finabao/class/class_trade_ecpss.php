<?php

finaload('class/trade_interface');

class Trade_ecpss implements trade_interface
{
    /**
     * 交易的用户ID
     */
    var $_uid;
    /**
     * 发生金额
     */
    var $_money;
    /**
     * 订单号
     */
    var $_order;
    /**
     * 支付通道
     */
    var $_passage;

    private     $_merchantid    =   '17985';
    private     $_md5key        =   'i]buVegR';
    public      $_gate          =   'https://pay.ecpss.cn/sslpayment';
    private     $_member_url    =   'https://www.finabao.com/index.php?mod=api&action=trade&passage=ecpss';
    private     $_system_url    =   'https://www.finabao.com/index.php?mod=api&action=topup&passage=ecpss';

    public function __construct()
    {
        global $_G;

        $passage        =	$_G[APP_NAME]['cache']['passage'];
        $this->_passage =   $passage['ecpss'];
    }
    /**
     * 创建订单号
     */
    public function creadeOrder()
    {

    }
    /**
     * 提交订单信息到接口
     */
    public function submitOrder($money)
    {
        global $_G;
        if(!$_G['uid']) showmessage('to_login');
        $this->_uid     =   $_G['uid'];
        if($money > '200000') showmessage('单笔金额不能超过20万');
        if($money < '0.01') showmessage('请输入正确的金额');
        $table_trade = C::t('finabao_topup')->creade_topup_order($this->_uid, finanum($money), $this->_passage['sign'], '金融宝账户余额充值结算');

        $this->_order   =   $table_trade['trade'];
        $this->_money   =   finanum($money);
        self::saveOrder();

        $order  =   array(
            'MerNo'            =>  $this->_merchantid,
            'BillNo'           =>  $this->_order,
            'Amount'           =>  $this->_money,
            'ReturnURL'        =>  $this->_member_url,
            'AdviceURL'        =>  $this->_system_url,
            'MD5info'          =>  $this->verifyKey($this->_md5key),
            'Remark'           =>  $_G['uid'].'_'.$_G['username'],
            'products'         =>  '金融宝'
        );
        return $order;
    }
    /**
     * 储存订单信息到数据库
     */
    public function saveOrder()
    {


    }
    /**
     * 确认订单状态
     */
    public function enterOrder($order)
    {

    }

    public function varifyReturn()
    {

        $return     =   $_REQUEST;
        $md5src = strtoupper(md5($return['BillNo'].$return['Amount'].$return['Succeed'].$this->_md5key));
        writelog('trade_topup_verify', TIMESTAMP.' '.$md5src.''.$return['MD5info']);
        return ($md5src == $return['MD5info'] && $return['Succeed'] == '88') ? $return : false;

    }
    /**
     * 对订单进行验证
     */
    public function verifyOrder()
    {

    }
    /**
     * 通过密钥验证
     */
    public function verifyKey($key)
    {
        return strtoupper(md5($this->_merchantid.$this->_order.$this->_money.$this->_member_url.$key));
    }

    public function returnMember()
    {
        global $_G;
        if($return = $this->varifyReturn()){

            if(C::t('finabao_topup')->enter_topup_success($return['BillNo'])){
                C::t('finabao_settle')->topup($return['BillNo']);
            }

            $return['money']    =   finanum($return['Amount']);
            $return['trade']    =   $return['BillNo'];
            $return['dateline'] =   gmdate('Y-m-d H:i:s', TIMESTAMP + 3600 * 8);

            $navtitle   =   '金融宝收银台';

            include template('finabao/returnMember');

        } else {
            writelog('trade_topup_error', TIMESTAMP.' '.serialize($_REQUEST));
        }
    }
    public function returnSystem()
    {

        if($return = $this->varifyReturn()){

            if(C::t('finabao_topup')->enter_topup_success($return['BillNo'])){
                C::t('finabao_settle')->topup($return['BillNo']);
                exit('ok');
            }

        } else {
            writelog('trade_topup_error', TIMESTAMP.' '.serialize($_REQUEST));
        }


    }
    static public function bank(){
        return array(
            'cmb'      =>  array('name'      =>  '招商银行','input'     =>  '1001'),
            'icbc'      =>  array('name'      =>  '工商银行','input'     =>  '1002'),
            'abc'      =>  array('name'      =>  '农业银行','input'     =>  '1005'),
            'boc'      =>  array('name'      =>  '中国银行','input'     =>  '1026'),
            'ccb'      =>  array('name'      =>  '建设银行','input'     =>  '1003'),
            'spdb'      =>  array('name'      =>  '浦发银行','input'     =>  '1004'),
            'gdb'      =>  array('name'      =>  '广发银行','input'     =>  '1036'),
            'boco'      =>  array('name'      =>  '交通银行','input'     =>  '1020'),
            'cmbc'      =>  array('name'      =>  '民生银行','input'     =>  '1006'),
            'cebb'      =>  array('name'      =>  '光大银行','input'     =>  '1022'),
            'cib'      =>  array('name'      =>  '兴业银行','input'     =>  '1009'),
            'pingan'      =>  array('name'      =>  '平安银行','input'     =>  '1035')
        );
    }
}

?>