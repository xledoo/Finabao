<?php


$passages       =   finacache('finabao_trade_passage', 'finabao_passage', 'sign');
$banks          =   finacache('finabao_banks', 'finabao_banks', 'sign');

if($_GET['action'] == 'sendsign'){

    $mobile     =   getgpc('mobile');

    if(strlen($mobile) != 11 || !preg_match("/^1[3|5|8][0-9]\d{4,8}$/", $mobile)){
        showmessage('手机号码格式输入错误', '', array(), array('handle' => false));
    }

    $lastime    =   $_G['timestamp']-180;
    if(C::t('#finabao#finabao_checkmobile')->check_sendtime($mobile, $signcode) > 1800){
        showmessage('180秒内只能发送一次验证短信', '', array(), array('handle' => false));
    }

    if(SMSverify($mobile)){
        showmessage('succeed', '', array(), array('handle' => false));
    }


} elseif($_GET['action'] == 'checkmobile'){

	$mobile     =   getgpc('mobile');
    if(strlen($mobile) != 11 || !preg_match("/^1[3|5|8][0-9]\d{4,8}$/", $mobile)){
        showmessage('手机号码格式输入错误', '', array(), array('handle' => false));
    }
	
	if(DB::result_first("SELECT uid FROM %t WHERE mobile=%s", array('common_member_profile', $mobile))){
		showmessage('该手机号码已经被注册，请重新输入。', '', array(), array('handle' => false));
	}

	showmessage('succeed', '', array(), array('handle' => false));


} elseif($_GET['action'] == 'checksign') {

	$mobile     =   getgpc('mobile');
	$signcode   =   getgpc('signcode');
    if(strlen($mobile) != 11 || !preg_match("/^1[3|5|8][0-9]\d{4,8}$/", $mobile)){
        showmessage('手机号码格式输入错误', '', array(), array('handle' => false));
    }
    if(strlen($signcode) != 6){
        showmessage('短信验证码错误', '', array(), array('handle' => false));
    }
	if(C::t('#finabao#finabao_checkmobile')->check($mobile, $signcode)){
		showmessage('succeed', '', array(), array('handle' => false));
	}
	showmessage('短信验证码错误', '', array(), array('handle' => false));

} elseif($_GET['action'] == 'passagebank'){


	if(formcheck('passage', true, 1)){

		$passage	=	getgpc('passage');
		if($passage	==	'undefined'){
			showmessage('请先选择第三方支付通道', '', array(), array('handle' => false));
		}


		if(!array_key_exists($passage, $passages)){
			showmessage('没有找到相关支付通道或银行的信息', '', array(), array('handle' => false));
		}
        finaload('class/trade_'.$passage);

        $tradeClassName =   'Trade_'.$passage;
        $tradeClass =   new $tradeClassName;
        $banklist   =   $tradeClass->bank();

        $hash       =   finahash();

        include template('finabao/topup_banklist');
    }

} elseif($_GET['action'] == 'topupbank'){

    if(formcheck('passage', true, 1)){

        $passage    =   getgpc('passage');
        $bank       =   getgpc('bank');
        if($passage ==  'undefined'){
            showmessage('请先选择第三方支付通道', '', array(), array('handle' => false));
        }

        $pbank      =   DB::fetch_all("SELECT * FROM ".DB::table('finabao_bankbindpassage')." WHERE `passage`='$passage' AND `bank`='$bank'");

        include template('finabao/topup_passagebank');

    }

} elseif($_GET['action'] == 'addbank'){


    if(!submitcheck('addbank_submit')){

        $banklist   =   $_G[APP_NAME]['cache']['banks'];
        include template('finabao/ajax_addbank');
    } else {

        finaload('class/member_card');

        $bankClass  =   new BankCrad($_G['uid']);

        $bankClass->add(getgpc('bank'), getgpc('cardname'), getgpc('cardid'), getgpc('openbank'));

        showmessage('添加成功', dreferer());

    }

} elseif($_GET['action'] == 'setpaypass'){

	if(!$_G['uid']) showmessage('to_login');

	if(!submitcheck('setpaypass_submit')){

		$iset	=	checkpaypass($_G['uid']);

		include template('finabao/ajax_setpaypass');
	} else {

        if(strlen(getgpc('paypass')) < 3) showmessage('支付密码不得少于 3 位哦！');
        if(getgpc('paypass') != getgpc('repaypass')) showmessage('两次输入的支付密码不一样，请重新输入。');

        DB::update('common_member_profile', array('field8' => md5(getgpc('paypass'))), array('uid' => $_G['uid']));
        showmessage('支付密码设置成功', dreferer());
	}

} elseif($_GET['action'] == 'bsie'){


    include template('finabao/bsie6');
}

function SMSverify($mobile){
    global $_G;

    finaload('class/smsender');

    $SMSender   =   new SMSender($_G['setting']['sms_username'], $_G['setting']['sms_password'], $_G['setting']['sms_charset'], $_G['setting']['sms_apiurl']);
    $random     =   random(6, 1);

    if($SMSender->SendSMS($mobile, '您的手机号：'.$mobile.'，注册验证码：'.$random.'，一天内提交有效，如不是本人操作请忽略！', 'register')){

        return C::t('#finabao#finabao_checkmobile')->add($mobile, $random);
    }
    return false;

}

?>