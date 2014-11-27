<?php


if(!submitcheck('paypass_submit')) {


    include template('home/spacecp_profile_paypass');
} else {


    if(getgpc('newpaypass') != getgpc('newpaypass2')){
        showmessage('两次输入的支付密码不一致 请重新输入', dreferer());
    }

    if(C::t('finabao_settle_member')->update_paypass($_G['uid'], getgpc('oldpaypass'), getgpc('newpaypass'))){
        showmessage('支付密码设置成功', dreferer());
    } else {
        showmessage('原支付密码输入错误', dreferer());
    }
}



?>