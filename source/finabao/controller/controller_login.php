<?php

	require_once libfile('function/member');
	require_once libfile('class/logging', 'finabao');

	$ctl_obj = new logging_ctl();
	$ctl_obj->setting = $_G['setting'];
	$method = 'on_'.$_GET['action'];
	$ctl_obj->template = 'member/login';
	$ctl_obj->on_login();

?>