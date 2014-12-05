<?php

require_once libfile('function/finabao');

finaload('class/trade_settle');

$settle =   new TradeSettle;

$members     =       DB::fetch_all("SELECT * FROM %t m LEFT JOIN %t p ON m.uid=p.uid ORDER BY regdate DESC", array('common_member', 'common_member_profile'));

foreach ($members as $key => $value) {
    $value['regdate']       =       dgmdate($value['regdate'], 'u', 8);
    $value['settle']        =       $settle->settle($value['uid']);
    $value['topcount']      =       DB::result_first('SELECT COUNT(*) FROM %t WHERE uid=%d AND status=%d', array('plugin_finabao_trade_topup', $value['uid'], '2'));
    $memberlist[]           =       $value;
}

include template('admincp/settle_memberlist');
?>