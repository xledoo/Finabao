<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_finabao_trade_settle extends discuz_table {

    public function __construct() {
        $this->_table = 'finabao_trade_settle';
        $this->_pk = 'id';

        parent::__construct();
    }

    public function topup($order)
    {
        if(!$trade  =   slef::getTradeInfo($order)) self::log('topup', '没有找到该订单的信息');
        if($trade['status'] != 1) self::log('topup', '该订单状态错误');


    }

    /**
     * 通过订单号获取订单信息
     */
    public function getTradeInfo($order, $type = 'topup')
    {
        $trade  =   DB::fetch_first("SELECT * FROM ".DB::table('finabao_trade_'.$type)." WHERE trade='$order'");
        return !empty($trade) ? $trade : false;
    }

    /**
     * 错误日志
     */
    public function log($m, $str)
    {
        global $_G;
        $uid = $_G['uid'];
        writelog('trade_settle_error', TIMESTAMP.'['.$uid.'][ClassTradeSettle::'.$m.']'.$str);
    }


}

?>