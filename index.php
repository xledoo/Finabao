<?php


define('FINA_NAME', 'finabao');
define('FINA_VERSION', '1.0.0');
define('FINA_RELEASE', '20141111');

require_once './source/class/class_core.php';
$discuz = C::app();
$discuz->init();

$controller	=	in_array(getgpc('c'), array('index', 'topup', 'refund', 'account','register','login')) ? getgpc('c') : 'index';

require_once libfile('function/finabao', FINA_NAME);
require_once libfile('controller/'.$controller, FINA_NAME);
?>