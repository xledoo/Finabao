<?php

define('APPTYPEID', 0);
define('NOROBOT', TRUE);
define('FINA_NAME', 'finabao');
define('FINA_VERSION', '1.0.0');
define('FINA_RELEASE', '20141111');

require_once './source/class/class_core.php';

$discuz = C::app();
$discuz->init();

$controller	=	in_array(getgpc('c'), array('account', 'ajax', 'member', 'topup', 'refund', 'iframe', 'api', 'creditcard', 'paypass', 'risk', 'test','register','login')) ? getgpc('c') : 'index';


// if ($controller == 'register') {
// 	require libfile('function/member');
// 	require libfile('class/member');
// 	require DISCUZ_ROOT.'./source/module/member/member_'.$controller.'.php';
// } else {
	require_once libfile('function/finabao', FINA_NAME);
	require_once libfile('controller/'.$controller, FINA_NAME);
// }
// ?>