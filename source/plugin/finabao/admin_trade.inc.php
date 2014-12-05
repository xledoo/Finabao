<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include libfile('function/finabao');

$passages   =   finacache('plugin_finabao_trade_passage',   'finabao_passage',  'sign');
$banks      =   finacache('plugin_finabao_banks',           'finabao_banks',    'sign');

$topup_status   =   array(
    0 => '<span class="text-danger">未支付</span>',
    1 => '<span class="text-info">待入账</span>',
    2 => '<span class="text-success">已入账</span>'
);

$topup = DB::fetch_all("SELECT * FROM %t ORDER BY dateline DESC", array('plugin_finabao_trade_topup'));

foreach ($topup as $key => $value) {
    $value['md5ver']        =   md5(serialize(array('uid' => $value['uid'], 'passage' => $value['passage'], 'trade' => $value['trade'], 'money' => $value['money'], 'dateline' => $value['dateline'], 'remark' => $value['remark'])));
    $value['isverify']      =   $value['md5ver'] == $value['verify'] ? true : false;
    $value['dateline']  	=   dgmdate($value['dateline'], 'u', 8);
    $value['username']  	=   DB::result_first("SELECT username FROM %t WHERE uid=%d", array('common_member', $value['uid']));
	$value['statustext']	=	$topup_status[$value['status']];
    $value['passage']       =   $passages[$value['passage']]['name'];

    $toplist[]          	=   $value;
}

include template('admincp/trade_topuplist');

?>