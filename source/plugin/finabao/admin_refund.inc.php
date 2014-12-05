<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once libfile('function/finabao');
$refundstatus   =   array('0' => array('title' => '待审核', 'class' => 'danger'), '1' => array('title' => '已审核', 'class' => 'warning'), '2' => array('title' => '已结算', 'class' => 'success'));
$adminscript    =   ADMINSCRIPT;
$formhash       =   formhash();
$retype         =   finacache('plugin_finabao_trade_retype',    'finabao_retype',   'retype');
$banks          =   finacache('plugin_finabao_banks',           'finabao_banks',    'sign');
finaload('class/trade_settle');
$settleClass    =   new TradeSettle;
$today      =   gmdate("Y-m-d", TIMESTAMP + 8 * 3600);
$starttime  =   getgpc('dateline1');
$endtime    =   getgpc('dateline2');
$starttime  =   strtotime($starttime);
$endtime    =   strtotime($endtime)+ 3600*24-1;

$_G['setting']['memberperpage'] = getgpc('perpage');
$page = max(1, $_G['page']);
$start_limit = ($page - 1) * $_G['setting']['memberperpage'];
$ppp = $_G['setting']['memberperpage'];
$count = DB::result_first('SELECT COUNT(*) FROM %t', array('plugin_finabao_trade_refund'));
$orderby = isset($_GET['orderby']) ? $_GET['orderby'] : '';
$ordersc = isset($_GET['ordersc']) ? $_GET['ordersc'] : '';
$perpages = isset($_GET['perpages']) ? $_GET['perpages'] : '';

if(submitcheck('refund_enter_submit')){

    $trade  =   DB::fetch_first("SELECT * FROM %t WHERE trade=%s AND status=%d", array('plugin_finabao_trade_refund', getgpc('trade'), 1));

    $today  =   gmdate("Y-m-d", TIMESTAMP + 3600 * 8);

    if(gmdate("Y-m-d", $trade['predictime'] + 3600 * 8) != $today && $trade['predictime'] > TIMESTAMP){
        cpmsg('未到打款时间 不能提前打款', '', 'error');
    }

    if($settleClass->unfreeze($trade['trade'])){

        DB::update('plugin_finabao_trade_refund', array('status' => 2, 'verifytime' => TIMESTAMP, 'verifyid' => $_G['uid']), array('trade' => $trade['trade'], 'status' => '1'));
        cpmsg('订单打款成功', dreferer(), 'succeed');
    }


} elseif(submitcheck('refund_verify_submit')){

    $trade  =   DB::fetch_first("SELECT * FROM %t WHERE trade=%s AND status=%d", array('plugin_finabao_trade_refund', getgpc('trade'), 0));

    DB::update('plugin_finabao_trade_refund', array('status' => 1, 'verifytime' => TIMESTAMP, 'verifyid' => $_G['uid']), array('trade' => $trade['trade']));

    cpmsg('订单审核成功', dreferer(), 'succeed');

    include template('admincp/refund_trade');


} else {

    $suburl     =   $_SERVER['REQUEST_URI'];

    $multipage = multi($count, $ppp, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$do".$filteradd);
    if(submitcheck('refund_search_submit')){
        $refundlist =   DB::fetch_all("SELECT * FROM %t WHERE %s BETWEEN %s AND %s ORDER BY ".DB::order($orderby, strtoupper($ordersc)), array('plugin_finabao_trade_refund', $orderby, $starttime, $endtime));
    } else {
        $refundlist =   DB::fetch_all("SELECT * FROM %t ORDER BY dateline DESC".DB::limit($start_limit, $_G['setting']['memberperpage']), array('plugin_finabao_trade_refund'));
    }
    foreach ($refundlist as $key => $value) {
        $value['dateline']      =   dgmdate($value['dateline'], 'u', 8);
        $value['member']        =   DB::fetch_first("SELECT * FROM %t m LEFT JOIN %t p ON m.uid=p.uid WHERE m.uid=%d", array('common_member', 'common_member_profile', $value['uid']));
        $value['predictime']    =   finadate($value['predictime'], 'u', 8);
        $value['factorage']     =   finanum($value['factorage']);
        $value['money']         =   finanum($value['money']);
        $value['deal']          =   finanum($value['deal']);
        $value['type']          =   $retype[$value['type']]['title'];
        $value['topup']         =   finanum(DB::result_first("SELECT SUM(money) FROM %t WHERE uid=%d AND status=2 AND settled=1", array('plugin_finabao_trade_topup', $value['uid'])));
        $value['refund']        =   finanum(DB::result_first("SELECT SUM(money) FROM %t WHERE uid=%d", array('plugin_finabao_trade_refund', $value['uid'])));
        $value['statustext']    =   '<span class="text-'.$refundstatus[$value['status']]['class'].'">'.$refundstatus[$value['status']]['title'].'</span>';
        $value['rebank']        =   unserialize(authcode($value['rebank'], 'DECODE', $value['trade']));
        $value['rebank']['bankname']    =   $banks[$value['rebank']['banksign']]['bankname'];
        $value['settle']        =   $settleClass->settle($value['uid']);
        $refundarr[]            =   $value;
    }
    include template('admincp/refund');

}




?>