<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('login');?><?php include template('common/header'); $loginhash = 'L'.random(4);?><?php if(empty($_GET['infloat'])) { include template('member/login_nofloat'); } else { include template('member/login_infloat'); } ?>



<div id="layer_message_<?php echo $loginhash;?>"<?php if(empty($_GET['infloat'])) { ?> class="f_c blr nfl"<?php } ?> style="display: none;">
<h3 class="flb" id="layer_header_<?php echo $loginhash;?>">
<?php if(!empty($_GET['infloat']) && !isset($_GET['frommessage'])) { ?>
<em>用户登录</em>
<span><a href="javascript:;" class="flbc" onclick="hideWindow('login')" title="关闭">关闭</a></span>
<?php } ?>
</h3>
<div class="c"><div class="alert_right">
<div id="messageleft_<?php echo $loginhash;?>"></div>
<p class="alert_btnleft" id="messageright_<?php echo $loginhash;?>"></p>
</div>
</div>
<script type="text/javascript" reload="1">
<?php if(!isset($_GET['viewlostpw'])) { ?>
var pwdclear = 0;
function initinput_login() {
document.body.focus();
<?php if(!$auth) { ?>
if($('loginform_<?php echo $loginhash;?>')) {
$('loginform_<?php echo $loginhash;?>').username.focus();
}
<?php if(!$this->setting['autoidselect']) { ?>
simulateSelect('loginfield_<?php echo $loginhash;?>');
<?php } } ?>
}
initinput_login();
<?php if($this->setting['sitemessage']['login']) { ?>
showPrompt('custominfo_login_<?php echo $loginhash;?>', 'mouseover', '<?php echo trim($this->setting['sitemessage']['login'][array_rand($this->setting['sitemessage']['login'])]); ?>', <?php echo $this->setting['sitemessage']['time'];?>);
<?php } ?>

function clearpwd() {
if(pwdclear) {
$('password3_<?php echo $loginhash;?>').value = '';
}
pwdclear = 0;
}
<?php } else { ?>
display('layer_login_<?php echo $loginhash;?>');
display('layer_lostpw_<?php echo $loginhash;?>');
$('lostpw_email').focus();
<?php } ?>
</script><?php updatesession();?><?php include template('common/footer'); ?>