<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('register');?><?php include template('common/header'); ?><script type="text/javascript">
var strongpw = new Array();
<?php if($_G['setting']['strongpw']) { if(is_array($_G['setting']['strongpw'])) foreach($_G['setting']['strongpw'] as $key => $val) { ?>strongpw[<?php echo $key;?>] = <?php echo $val;?>;
<?php } } ?>
var pwlength = <?php if($_G['setting']['pwlength']) { ?><?php echo $_G['setting']['pwlength'];?><?php } else { ?>0<?php } ?>;
</script>
<script src="static/js/register.js" type="text/javascript" type="text/javascript"></script>
<div class="container">
<div class="lineH"></div>
<div class="nfl" id="main_succeed" style="display: none">
<div class="f_c altw">
<div class="alert_right">
<p id="succeedmessage"></p>
<p id="succeedlocation" class="alert_btnleft"></p>
<p class="alert_btnleft"><a id="succeedmessage_href">如果您的浏览器没有自动跳转，请点击此链接</a></p>
</div>
</div>
</div>
    <p id="returnmessage4"></p>
<div class="row" id="main_message">
<div class="span4 col-sm-4"><img src="static/finabao/fimages/adv_register.jpg" /></div>
<div class="span8 col-sm-8">
<div class="cont-title-bar clearfix">
<h2 class="text-title"><?php if($_GET['action'] != 'activation') { ?><?php echo $this->setting['reglinkname'];?><?php } else { ?>您的帐号需要激活<?php } ?></h2>
<span class="more"><a href="member.php?mod=logging&amp;action=login&amp;referer=<?php echo rawurlencode($dreferer); ?>" onClick="showWindow('login', this.href);return false;">已有帐号？现在登录</a></span>
</div>
<?php if($this->showregisterform) { ?>
<form method="post" autocomplete="off" name="register" id="registerform" enctype="multipart/form-data" onsubmit="checksubmit();return false;" action="index.php?mod=member&amp;action=register">
<input type="hidden" name="regsubmit" value="yes" />
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="referer" value="<?php echo $dreferer;?>" />
<input type="hidden" name="activationauth" value="<?php if($_GET['action'] == 'activation') { ?><?php echo $activationauth;?><?php } ?>" />
<?php if($_G['setting']['sendregisterurl']) { ?>
<input type="hidden" name="hash" value="<?php echo $_GET['hash'];?>" />
<?php } ?>
                <div class="f-line"></div>
                <div class="row" style="position:relative; height:250px;">
<div class="f-cb span4" style="float:left; position:absolute;">
<div class="control-group form-group" id="group_<?php echo $this->setting['reginput']['username'];?>">
<label class="control-label" for="<?php echo $this->setting['reginput']['username'];?>">用户名</label>
<div class="controls"><input type="text" id="<?php echo $this->setting['reginput']['username'];?>" style="width: 270px;height: 22px;" onblur="checkusername(this.id);" data-placement="top" title="用户名由 5 到 15 个字母或数字组成，不能包含符号或中文。" name="" class="form-control u-ipt" tabindex="1" autocomplete="off" size="25" maxlength="15" required /></div>
<div><i id="tip_<?php echo $this->setting['reginput']['username'];?>" class="p_tip"></i><kbd id="chk_<?php echo $this->setting['reginput']['username'];?>" class="p_chk"></kbd></div>
                	</div>
<div class="control-group form-group" id="group_<?php echo $this->setting['reginput']['password'];?>">
<label class="control-label" for="<?php echo $this->setting['reginput']['password'];?>">密码</label>
<div class="controls"><input type="password" id="<?php echo $this->setting['reginput']['password'];?>" name="" style="width: 270px;height: 22px;" data-toggle="tooltip" title="请填写密码<?php if($_G['setting']['pwlength']) { ?>, 最小长度为 <?php echo $_G['setting']['pwlength'];?> 个字符<?php } ?>" style="*height:20px;" size="25" tabindex="1" class="form-control u-ipt" required /></div>
<p><i id="tip_<?php echo $this->setting['reginput']['password'];?>" class="p_tip"></i><kbd id="chk_<?php echo $this->setting['reginput']['password'];?>" class="p_chk"></kbd></p>
                	</div>
<div class="control-group form-group" id="group_<?php echo $this->setting['reginput']['password2'];?>">
<label class="control-label" for="<?php echo $this->setting['reginput']['password2'];?>">确认密码:</label>
<div class="controls"><input type="password" id="<?php echo $this->setting['reginput']['password2'];?>" data-toggle="tooltip" style="width: 270px;height: 22px;" title="请再次输入密码" name="" size="25" tabindex="1" value="" class="form-control u-ipt" required /></div>
<p><i id="tip_<?php echo $this->setting['reginput']['password2'];?>" class="p_tip"></i><kbd id="chk_<?php echo $this->setting['reginput']['password2'];?>" class="p_chk"></kbd></p>
</div>
                </div>
                <div class="span4" style="float:right; position:absolute; right:10px;">
<div class="control-group form-group" id="group_<?php echo $this->setting['reginput']['email'];?>">
<label class="control-label" for="<?php echo $this->setting['reginput']['email'];?>">Email</label>
<div class="controls"><input type="text" id="<?php echo $this->setting['reginput']['email'];?>" data-toggle="tooltip" title="请输入正确的邮箱地址" style="width: 270px;height: 22px;" name="" autocomplete="off" size="25" tabindex="1" class="form-control u-ipt" value="<?php echo $hash['0'];?>" required /><em id="emailmore" style="position:absolute;">&nbsp;</em></div>
<p><i id="tip_<?php echo $this->setting['reginput']['email'];?>" class="p_tip"></i><kbd id="chk_<?php echo $this->setting['reginput']['email'];?>" class="p_chk"></kbd></p>
                	</div>
<div class="control-group form-group" id="group_mobile">
<label class="control-label" for="mobile">手机号码</label>
<div class="controls"><input type="text" id="mobile" data-toggle="tooltip" style="width: 270px;height: 22px;" title="请输入您的手机号码" name="" autocomplete="off" size="25" tabindex="1" class="form-control u-ipt" value="" /></div>
<p><i id="tip_mobile" class="p_tip"></i><kbd id="chk_mobile" class="p_chk"></kbd></p>
                	</div>
<div class="control-group form-group" id="group_signcode">
                        <label class="control-label" for="signcode">短信验证码</label>
<div class="controls input-append form-online input-group"><input type="text" name="" data-toggle="tooltip" maxlength="6" tabindex="1" title="请输入收到的短信验证码" id="signcode" style="width:100px;height: 22px;" class="form-control u-ipt"><span class="input-group-btn"><button class="btn btn-info" type="button" style="position:absolute; top:0px; _position:relative; _height:34px; _top:-36px; _left:110px;" id="smscheck">短信验证码</button></span></div>
<p><i id="tip_signcode" class="p_tip"></i><kbd id="chk_signcode" class="p_chk"></kbd></p>
                    </div>
                    <div class="control-group form-group">
                        <label class="checkbox"><input type="checkbox" name="agreebbrule" value="<?php echo $bbrulehash;?>" id="agreebbrule" checked="checked" /> <label for="agreebbrule">同意<a href="javascript:;" onclick="showBBRule()">网站服务条款</a></label></label>
                    </div>
                    </div>
</div>
</div>
<div class="span8 col-xs-8 form-group">
<div class="form-actions" style="text-align:center;">
                	<button class="btn btn-primary" id="registerformsubmit" type="submit" name="regsubmit" value="true" tabindex="1"><strong><?php if($_GET['action'] == 'activation') { ?>激活<?php } else { ?>提交注册信息<?php } ?></strong></button>
<button type="reset" class="btn btn-default">放弃重填</button>
</div>
                <textarea style="height:150px; width:98%;" readonly="readonly"><?php echo strip_tags($bbrulestxt);?></textarea>
</div>
            </form>

            <?php } ?>
</div>
    </div>
</div>


</div>
<div id="layer_regmessage"class="f_c blr nfl" style="display: none">
<div class="c"><div class="alert_right">
<div id="messageleft1"></div>
<p class="alert_btnleft" id="messageright1"></p>
</div>
</div>

<div id="layer_bbrule" style="display: none">
<div class="c" style="width:700px;height:350px;overflow:auto"><?php echo $bbrulestxt;?></div>
<p class="fsb pns cl hm">
<button class="pn pnc" onclick="$('agreebbrule').checked = true;hideMenu('fwin_dialog', 'dialog');<?php if($this->setting['sitemessage']['register'] && ($bbrules && $bbrulesforce)) { ?>showRegprompt();<?php } ?>"><span>同意</span></button>
<button class="pn" onclick="location.href='<?php echo $_G['siteurl'];?>'"><span>不同意</span></button>
</p>
</div>
<script type="text/javascript">
jQuery(".form-control").each(function(i){
if(jQuery(".form-control").eq(i).attr("title")){
jQuery("#"+this.id).tooltip();
}
});

jQuery("#smscheck").click(function(){
var err	=	0;
jQuery(".control-group").each(function(i){
if(i <= 4){
if(!this.className.match(/ has-success/)){
jQuery(".control-group input").eq(i).focus();
err = 1;
return false;
}
}
});

if(err == 0){
var x = new Ajax();
x.get('index.php?mod=ajax&inajax=yes&infloat=register&handlekey=register&ajaxmenu=1&action=sendsign&mobile=' + jQuery("#mobile").val(), function(s) {
if(s == 'succeed') {
$('chk_signcode').innerHTML = '验证短信已经发送成功，请等待。';
jQuery("#smscheck").attr("disabled", "disabled");
} else {
$('chk_signcode').innerHTML = s;
}
});

}
});

function checksign(id){
errormessage(id);
var signcode = trim($(id).value);
var mobile   = trim($('mobile').value);
//if(signcode.length == 6 && (/^[1-9]\d*$|^0$/.test(signcode))){
var x = new Ajax();
$('tip_' + id).parentNode.className = $('tip_' + id).parentNode.className.replace(/ p_right/, '');
x.get('index.php?mod=ajax&inajax=yes&infloat=register&handlekey=register&ajaxmenu=1&action=checksign&mobile=' + jQuery("#mobile").val() +'&signcode=' + signcode, function(s) {
errormessage(id, s);
});
//} else {
//	errormessage(id, '短信验证码格式错误');
//	return;
//}
}
var ignoreEmail = <?php if($_G['setting']['forgeemail']) { ?>true<?php } else { ?>false<?php } ?>;
<?php if($bbrules && $bbrulesforce) { ?>
showBBRule();
<?php } if($this->showregisterform) { if($sendurl) { ?>
addMailEvent($('<?php echo $this->setting['reginput']['email'];?>'));
<?php } else { ?>
addFormEvent('registerform', <?php if($_GET['action'] != 'activation' && !($bbrules && $bbrulesforce) && !empty($invitecode)) { ?>1<?php } else { ?>0<?php } ?>);
<?php } if($this->setting['sitemessage']['register']) { ?>
function showRegprompt() {
showPrompt('custominfo_register', 'mouseover', '<?php echo trim($this->setting['sitemessage']['register'][array_rand($this->setting['sitemessage']['register'])]); ?>', <?php echo $this->setting['sitemessage']['time'];?>);
}
<?php if(!($bbrules && $bbrulesforce)) { ?>
showRegprompt();
<?php } } ?>
function showBBRule() {
showDialog($('layer_bbrule').innerHTML, 'info', '<?php echo addslashes($this->setting['bbname']);; ?> 网站服务条款');
$('fwin_dialog_close').style.display = 'none';
}
<?php } ?>
</script>

</div></div>
</div><?php updatesession();?><?php include template('common/footer'); ?>