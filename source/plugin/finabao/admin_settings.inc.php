<?php


include libfile('function/finabao');

$passages   =   finacache('plugin_finabao_trade_passage', 'finabao_passage', 'sign');
if(getgpc('setpassage')) {

    showtableheader('支付通道配置 Passage');

    $sign   =   getgpc('sign');


    if(!$passages[$sign]) cpmsg('没有找到该通道的信息');

    $passage    =   $passages[$sign];
    showformheader("credits&operation=list");
    showsetting('通道名称', 'name', $passage['name'], 'text');
    showsetting('通道识标', 'sign', $passage['sign'], 'text');
    showsetting('通道编号', 'code', $passage['code'], 'text');
    showsetting('商户号',   'merchant', $passage['merchant'], 'text');
    showsetting('通信密钥',   'secretkey', $passage['secretkey'], 'text');
    showsetting('支付地址',   'payapi', $passage['payapi'], 'text');
    showsetting('参数传递', 'content', $passage['content'], 'textarea');
    showformfooter();
    showtablefooter();

} elseif(getgpc('setbankpassage')) {

    debug($POST);

} else {


    showtableheader('基本设置 Base');
    showtablefooter();
    /**
     * 支付通道
     */

    showtableheader('支付通道配置 Passage');
    showtableheader();
    showsubtitle(array('display_order', '通道名称', '通道识标', '通道编码', '商户号', '库名', '历史数据', '当月数据', '启用', '详细配置'));


    foreach ($passages as $key => $value) {
        showtablerow('', array('class="td25"', 'class="td28"', '', '', 'class="td28"'), array(
            '<input type="text" class="txt" name="displayorder['.$value[id].']" value="'.$value['displayorder'].'" size="3" />',
            $value['name'],
            $value['sign'],
            $value['code'],
            $value['merchant'],
            '',
            '0.00',
            '0.00',
            '<input class="checkbox" type="checkbox" value="1" name="usable['.$value[id].']" '.($value['usable'] == 1 ? "checked" : '').'>',
            '<a href="admin.php?action=plugins&operation=config&do='.getgpc('do').'&identifier=finabao&pmod=admin_settings&formhash='.formhash().'&setpassage=yes&sign='.$value['sign'].'">详细配置</a>'
        ));
    }
    showtablefooter();

    /**
     * 银行支付限额
     */
    $bankbindpassage    =   updatecache_bankbindpassage();
    $passages           =   updatecache_passage();
    $banks              =   updatecache_banks();
    showtableheader('银行支付限额 Passage for Bank');
    showsubtitle(array('delete', '通道名称(识标)', '银行名称(识标)', '单笔限额', '日限额', '月限额', '支付方式说明'));
    foreach ($bankbindpassage as $key => $value) {
        showtablerow( '', array('class="td25"', 'class="td28"', '', '', 'class="td28"'), array(
            '<input class="checkbox" type="checkbox" name="bankpassage" />',
            $passages[$value['passage']]['name'].' ('.$value['passage'].')',
            $banks[$value['bank']]['bankname'].' ('.$value['bank'].')',
            $value['sec'],
            $value['day'],
            $value['month'],
            $value['mark'],
        ));
    }
    echo '<tr><td>新增</td><td><input type="text" class="txt" name="newbankpassage[\'passage\']" /></td><td><input type="text" class="txt" name="newbankpassage[\'bank\']" /></td><td><input type="text" class="txt" name="newbankpassage[\'sec\']" /></td><td><input type="text" class="txt" name="newbankpassage[\'day\']" /></td><td><input type="text" class="txt" name="newbankpassage[\'month\']" /></td><td><input type="text" class="txt" name="newbankpassage[\'mark\']" /></td></tr>';
    showtablefooter();



    /**
    * 短信中心
    */
    showtableheader('短信中心 SMSCenter');
    showsetting('短信中心开关',   'settingnew[sms_off]',    $_G['setting']['sms_off'],    'radio',    '', 0,  '关闭则终止发送手机短信! “是”为打开短信中心');
    showsetting('短信中心用户名',   'settingnew[sms_username]',    $_G['setting']['sms_username'],    'text',    'readonly', 0,  '短信中心发送接口用户名');
    showsetting('短信中心密码',   'settingnew[sms_password]',    $_G['setting']['sms_password'],    'password',    'readonly', 0,  '短信中心发送接口密码');
    showsetting('发送接口',       'settingnew[sms_apiurl]', $_G['setting']['sms_apiurl'], 'textarea', 'readonly', 0, '{charset} 发送字符集 | {username} 用户名 | {password} 密码 | {mobile} 发送到手机 | {message} 发送内容', 'style="width:400px;"', '', 1);
    showsubmit('smssubmit');
    showtablefooter();
}






?>