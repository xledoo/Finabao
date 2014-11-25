<?php

    require_once libfile('function/member');
    require_once libfile('class/register', FINA_NAME);

	$ctl_obj = new register_ctl();
	$ctl_obj->setting = $_G['setting'];
	$method = 'on_'.$_GET['action'];
	$ctl_obj->template = 'member/register';
	$ctl_obj->on_register();

?>