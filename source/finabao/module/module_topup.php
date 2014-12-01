<?php

if(!$_G['uid']){
    showmessage('to_login');
}

$banklist   =   $_G[APP_NAME]['cache']['banks'];

if(!formcheck('topup_submit') && formcheck('sign', true, 1)){


	$hash		=	finahash();
	$formhash	=	formhash();
	$key		=	dsign('topup');

	include template('finabao/topup');

} else {

    if(formcheck('topup_submit')){

        finaload('class/trade_'.getgpc('passage'));

        $trade      =   'Trade_'.getgpc('passage');
        $trade      =   new $trade;

        $order      =   $trade->submitOrder($_POST['money']);
        $apiurl     =   $trade->_gate;

        include template('finabao/topup_autosubmit');
        exit();
    }
    showmessage("非法提交");
}




?>