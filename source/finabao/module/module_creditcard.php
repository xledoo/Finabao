<?php

$banklist   =   finacache('plugin_finabao_banks', 'finabao_banks', 'sign');
for ($i=1; $i < 32; $i++) {
    $datewarp[] = $i;
}

if(getgpc('action') == 'cardadd'){


    if(submitcheck('cardadd_submit', 1)){

        $get['cardid']       =   getgpc('cardid') ? str_replace(' ','',getgpc('cardid')) : showmessage('请输入信用卡卡号', dreferer());
        $get['recardid']     =   getgpc('recardid') ? str_replace(' ','',getgpc('recardid')) : showmessage('请输入正确的信用卡卡号', dreferer());
        $get['banksign']     =   getgpc('cardBank') ? trim(getgpc('cardBank')) : showmessage('请选择发卡银行', dreferer());
        $get['cardname']     =   getgpc('cardname') ? str_replace(' ','',getgpc('cardname')) : showmessage('请输入卡主姓名', dreferer());
        $get['billdate']     =   getgpc('billdate') ? intval(getgpc('billdate')) : showmessage('请选择账单日', dreferer());
        $get['givedate']     =   getgpc('givedate') ? intval(getgpc('givedate')) : showmessage('请选择还款日', dreferer());
        $get['limit']        =   getgpc('limit') ? intval(getgpc('limit')) : showmessage('请输入信用卡的授信额度', dreferer());
        $get['cardid'] != $get['recardid'] ? showmessage('两次输入的卡号不一致', dreferer()) : '';

        if(DB::result_first("SELECT id FROM %t WHERE cardid=%s", array('plugin_finabao_cards', $get['cardid']))){
            showmessage('该信用卡已经添加过了', dreferer());
        }

        $data   =   array(
            'uid'   =>  $_G['uid'],
            'username'  =>  $_G['username'],
            'type'  =>  1,
            'cardname'  =>  $get['cardname'],
            'cardid'    =>  $get['cardid'],
            'banksign'  =>  $get['banksign'],
            'dateline'  =>  TIMESTAMP,
            'billdate'  =>  $get['billdate'],
            'givedate'  =>  $get['givedate'],
            'limit'     =>  $get['limit'],
            'remark'    =>  daddslashes(getgpc('remark'))
        );

        DB::insert('plugin_finabao_cards', $data) ? showmessage('信用卡添加成功', 'index.php?mod=creditcard', 'success') : showmessage('该信用卡已经添加过了', dreferer());


    } else {

        include template('creditcard/cradadd');
    }


} elseif(getgpc('action') == 'editcard'){


    $card   =   DB::fetch_first("SELECT * FROM %t WHERE uid=%d AND id=%d", array('plugin_finabao_cards', $_G['uid'], getgpc('id')));
    if(!$card){
        showmessage('没有找到该卡片的信息', dreferer());
    }

    if(submitcheck('cardedit_submit')){

        $get['cardid']       =   getgpc('cardid') ? str_replace(' ','',getgpc('cardid')) : showmessage('请输入信用卡卡号', dreferer());
        $get['banksign']     =   getgpc('cardBank') ? trim(getgpc('cardBank')) : showmessage('请选择发卡银行', dreferer());
        $get['cardname']     =   getgpc('cardname') ? str_replace(' ','',getgpc('cardname')) : showmessage('请输入卡主姓名', dreferer());
        $get['billdate']     =   getgpc('billdate') ? intval(getgpc('billdate')) : showmessage('请选择账单日', dreferer());
        $get['givedate']     =   getgpc('givedate') ? intval(getgpc('givedate')) : showmessage('请选择还款日', dreferer());
        $get['limit']        =   getgpc('limit') ? intval(getgpc('limit')) : showmessage('请输入信用卡的授信额度', dreferer());

        DB::update('plugin_finabao_cards', $get, array('uid' => $_G['uid'], 'id' => getgpc('id'))) ? showmessage('信用卡编辑成功', 'index.php?mod=creditcard', 'success') : showmessage('信用卡编辑失败', 'index.php?mod=creditcard');

    } else {

        $card['ttid']   =   $card['cardid'];
        $card['cardid'] = substr($card['ttid'], 0, 4).' ';
        $card['cardid'] .= substr($card['ttid'], 4, 4).' ';
        $card['cardid'] .= substr($card['ttid'], 8, 4).' ';
        $card['cardid'] .= substr($card['ttid'], 12, 4);

        include template('creditcard/editcard');

    }




} elseif(getgpc('action') == 'delcard'){

    if(submitcheck('delcardsubmit', 1)){
        DB::delete('plugin_finabao_cards', array('uid' => $_G['uid'], 'id' => intval($_GET['id']), 'type' => 1)) ? showmessage('信用卡删除成功', 'index.php?mod=creditcard', 'success') : showmessage('信用卡添加失败', 'index.php?mod=creditcard');
    }

} else {

    $ccardlist  =   C::t('finabao_cards')->fetch_all_by_uids($_G['uid'], 'dateline', 'DESC', 1);

    foreach($ccardlist as $key => $var){
        $ccardlist[$key]['sortid']  =   substr($var['cardid'], -4);
        $ccardlist[$key]['remark']  =   cutstr($var['remark'], 8, '');
    }
    include template('creditcard/index');

}







?>