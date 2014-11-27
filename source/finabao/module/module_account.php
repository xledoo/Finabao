<?php


if(!$_G['uid']) showmessage('to_login', '', array(), array('login' => true));

$_G['setting']['memberperpage'] = 10;

if($_GET['action'] == 'index' || !isset($_GET['action'])){

	$formhash	=	finahash();
	$sign		=	dsign();

	$tradelist	=	array();

    $ccardnums  =   DB::result_first("SELECT COUNT(*) FROM %t WHERE uid=%d AND type=%d", array('plugin_finabao_cards', $_G['uid'], 1));

    finaload('class/trade_settle');

    $settle     =   C::t('finabao_settle')->settle_by_uid($_G['uid']);

    $tradetype  =   array(
        'topup'     =>  array(
            0 => '<span class="text-danger">未支付</span>',
            1 => '<span class="text-info">待入账</span>',
            2 => '<span class="text-success">已入账</span>'
        ),
        'refund'    =>  array(
            0 => '<span class="text-danger">待审核</span>',
            1 => '<span class="text-info">已审核</span>',
            2 => '<span class="text-success">已打款</span>'
        )
    );

    $list    =   C::t('finabao_settle')->settle_list($_G['uid'], $start_limit, $_G['setting']['memberperpage']);
    foreach ($list as $key => $value) {
        $value['dateline']  =   dgmdate($value['dateline'], 'Y-m-d H:i');
        $value['ext']       =   DB::fetch_first("SELECT * FROM %t WHERE trade=%s", array('plugin_finabao_trade_'.$value['type'], $value['trade']));
        $value['statushow'] =   $tradetype[$value['type']][$value['ext']['status']];
        $tradelist[]        =   $value;
    }

    include template('finabao/account_index');
}



?>