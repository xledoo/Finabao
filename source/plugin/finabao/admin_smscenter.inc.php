<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}


$page = max(1, $_G['page']);
$start_limit = ($page - 1) * 20;

showtableheader();
echo '<tr><th class="td25"><strong>序号</strong></th><th><strong>发送类型</strong></th><th><strong>发送号码</strong></th><th><strong>IP地址</strong></th><th style="width:420px"><strong>短信内容</strong></th><th><strong>发送时间</stong></th><th><strong>状态</strong></th></tr>';
$count  =   DB::result("SELECT COUNT(*) FROM ".DB::table('plugin_finabao_smsender'));
$ppp = 100;
$start_limit = ($page - 1) * 20;
$multipage = multi($count, 20, $page, ADMINSCRIPT."?action=members&operation=grouppmlist&do=$do");

$list = DB::fetch_all("SELECT * FROM ".DB::table('plugin_finabao_smsender')." ORDER BY `dateline` DESC LIMIT $start_limit, 20");

foreach($list as $k => $v){
    echo '<tr><td>'.($k+1).'</td><td>'.$v['action'].'</td><td>'.$v['mobile'].'</td><td>'.$v['sendip'].'</td><td>'.$v['message'].'</td><td>'.dgmdate($v['dateline']).'</td><td>'.($v['status'] == 0 ? '失败' : '成功').'</td></tr>';
}


showtablefooter();
echo $multipage;


?>