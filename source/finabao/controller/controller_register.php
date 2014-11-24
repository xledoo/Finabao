<?php
// debug($_G['setting']['reglinkname']);
    require_once libfile('function/member');
    require_once './source/finabao/class/register_ctl.php';

    $ctl_obj            =   new register_ctl();
    $ctl_obj->setting   =   $_G['setting'];
    $ctl_obj->template  =   'member/register';
    $ctl_obj->on_register();

?>