<?php

finaload('class/trade_interface');

class Trade_baofoo implements trade_interface
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

    private     $_merchantid    =   '118040';
    private     $_md5key        =   'r7x6jlk3mcwwrlhg';
    public      $_gate          =   'https://paygate.baofoo.com/PayReceive/bankpay.aspx';
    private     $_date          =   '';
    private     $_member_url    =   'https://www.finabao.com/index.php?mod=api&action=trade&passage=baofoo';
    private     $_system_url    =   'http://www.finabao.com/index.php?mod=api&action=topup&passage=baofoo';
    private     $_notice        =   0;
    private     $_payid         =   1000;

    public function __construct()
    {
        global $_G;
        $passage        =	$_G[APP_NAME]['cache']['passage'];
        $this->_passage =   $passage['baofoo'];
        $this->_date       =   date("YmdHis");
    }
    /**
     * 创建订单号
     */
    public function creadeOrder()
    {
        // yymmddhhiiss(12)+pp(2)+999(6) = 20
        $this->_order   =   date("ymdHis").$this->_passage['code'].random(6, 1);
        return $this->_order;
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
            'MerchantID'            =>  $this->_merchantid,
            'PayID'                 =>  $this->_payid,
            'TradeDate'             =>  $this->_date,
            'TransID'               =>  $this->_order,
            'OrderMoney'            =>  $money*100,
            'ProductName'           =>  'finabao.com',
            'Amount'                =>  1,
            'ProductLogo'           =>  '',
            'Username'              =>  $_G['uid'].'_'.$_G['username'],
            'Email'                 =>  $_G['member']['email'],
            'Mobile'                =>  $_G['member']['mobile'],
            'AdditionalInfo'        =>  $_G['uid'].'_'.$_G['username'],
            'Merchant_url'          =>  $this->_member_url,
            'Return_url'            =>  $this->_system_url,
            'NoticeType'            =>  $this->_notice,
            'Md5Sign'               =>  $this->verifyKey($money)
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
        $_MerchantID        =   $return['MerchantID'];//商户号
        $_TransID           =   $return['TransID'];//流水号
        $_Result            =   $return['Result'];//支付结果(1:成功,0:失败)
        $_resultDesc        =   $return['resultDesc'];//支付结果描述
        $_factMoney         =   $return['factMoney'];//实际成交金额
        $_additionalInfo    =   $return['additionalInfo'];//订单附加消息
        $_SuccTime          =   $return['SuccTime'];//交易成功时间
        $_Md5Sign           =   $return['Md5Sign'];//md5签名
        $_WaitSign          =   md5($_MerchantID.$_TransID.$_Result.$_resultDesc.$_factMoney.$_additionalInfo.$_SuccTime.$this->_passage['secretkey']);
        return ($_WaitSign == $_Md5Sign && $_Result == 1) ? $return : writelog('trade_topup_error', TIMESTAMP.' varifyReturn::'.serialize($_REQUEST));
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
        return md5($this->_merchantid.$this->_payid.$this->_date.$this->_order.($key*100).$this->_member_url.$this->_system_url.$this->_notice.$this->_md5key);
    }

    public function returnMember()
    {
        global $_G;
        if($return = $this->varifyReturn()){


            if(C::t('finabao_topup')->enter_topup_success($return['TransID'])){
                C::t('finabao_settle')->topup($return['TransID']);

            }

            $return['money']    =   finanum($return['factMoney']/100);
            $return['trade']    =   $return['TransID'];
            $return['dateline'] =   gmdate('Y-m-d H:i:s', TIMESTAMP + 3600 * 8);

            $navtitle   =   '金融宝收银台';

            include template('finabao/returnMember');

        } else {
            writelog('trade_topup_error', TIMESTAMP.' returnMember::'.serialize($_REQUEST));
        }
    }
    public function returnSystem()
    {

        if($return = $this->varifyReturn()){
            if(C::t('finabao_topup')->enter_topup_success($return['TransID'])){
                C::t('finabao_settle')->topup($return['TransID']);
                exit('returnSystem::success');
            }
        } else {
            writelog('trade_topup_error', TIMESTAMP.' returnSystem::'.serialize($_REQUEST));
        }


    }
    static public function bank(){
        return array(
            'icbc'      =>  array('name'      =>  '工商银行','input'     =>  '1002'),
            'cmb'      =>  array('name'      =>  '招商银行','input'     =>  '1001'),
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