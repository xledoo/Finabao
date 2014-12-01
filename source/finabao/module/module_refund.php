<?php

error_reporting(E_ALL);

if(!$_G['uid']){
    showmessage('to_login');
}

require_once libfile('function/finabao');

$passages   =   $_G[APP_NAME]['cache']['passage'];
$banklist   =   $_G[APP_NAME]['cache']['banks'];

finaload('class/trade_settle');
$settle     =   C::t('finabao_settle')->settle_by_uid($_G['uid']);
$retypelist =   $_G[APP_NAME]['cache']['retype'];
$paypass    =   checkpaypass($_G['uid']);

if(!formcheck('refund_submit') && formcheck('sign', true, 1)){

    finaload('class/member_card');
    $bank       =   new BankCrad($_G['uid']);
    $banklist   =   $bank->query();

    if(is_array($banklist)) {
        for ($i=0; $i < count($banklist); $i++) {
            $banklist[$i]['cardid'] = substr($banklist[$i]['cardid'], -4);
        }
    }


    include template('finabao/refund');

} elseif(formcheck('refund_submit')) {

    if(!getgpc('rebank')) showmessage('请选择提现的银行卡', dreferer());
    if(!getgpc('retype')) showmessage('请选择提现方式', dreferer());

    if(getgpc('money') < 10) showmessage('提现金额不能小于 10 元。', dreferer());

    $settle = C::t('finabao_settle')->settle_by_uid($_G['uid']);
    $settle['usable'] < getgpc('money') ? showmessage('提现金额不能超过可用余额。', dreferer()) : '';

    if(C::t('finabao_settle_member')->check_paypass($_G['uid'], getgpc('paypass'))){
        showmessage('支付密码输入错误', dreferer());
    }

    $redata     =   C::t('finabao_refund')->creade_refund_order($_G['uid'], finanum(getgpc('money')), getgpc('retype'), getgpc('rebank'), '客户自助提现结算');
    if(!$redata) showmessage('提现失败，请联系管理员。');

    $redata['type']  =   $retypelist[$redata['type']]['title'];
    $redata['money'] =   finanum($redata['money']);
    $redata['deal']  =   finanum($redata['deal']);
    $redata['predictime']     =   gmdate("Y-m-d H:i:s", $redata['predictime'] + 3600 * 8);
    $redata['dateline']       =   dgmdate($redata['dateline'], 'u');


    include template('finabao/refund_returnMemeber');
}




?>