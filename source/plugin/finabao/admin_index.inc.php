<script type="text/javascript" src="static/finabao/javascript/jquery-1.10.2.min.js"></script>
<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'./source/plugin/finabao/common.php';

showtableheader('基本配置信息');
showtablerow('', array('class="vtop td24 lineheight"', 'class="lineheight smallfont"'), array(
    '当前版本',
    APP_NAME.' - '.APP_VERSION.' - '.APP_RELEASE
));
showtablerow('', array('class="vtop td24 lineheight"', 'class="lineheight smallfont"'), array(
    '程序路径',
    APP_ROOT
));
showtablerow('', array('class="vtop td24 lineheight"', 'class="lineheight smallfont" id="sms_nums"'), array(
    '短信条数',
    '0'
));

showtablefooter();


?>