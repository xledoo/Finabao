<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<div class="f-line"></div>
<div class="f-line"></div>
<style type="text/css">

</style>
<div class="container" style="height:600px;">
<div class="row">
    	<div class="span8">
        	<div class="f-line"></div>
        	<img src="static/finabao/fimages/wireless.jpg" />
        </div>
        <div class="span4" style="position:relative;">
        	<div style=" border:1px solid #ccc; height:420px; width:340px; background:#f7f7f7; _width:335px;"></div>
<form method="post" autocomplete="off" name="login" id="loginform_<?php echo $loginhash;?>" class="cl" onsubmit="<?php if($this->setting['pwdsafety']) { ?>pwmd5('password3_<?php echo $loginhash;?>');<?php } ?>pwdclear = 1;ajaxpost('loginform_<?php echo $loginhash;?>', 'returnmessage_<?php echo $loginhash;?>', 'returnmessage_<?php echo $loginhash;?>', 'onerror');return false;" action="member.php?mod=logging&amp;action=login&amp;loginsubmit=yes<?php if(!empty($_GET['handlekey'])) { ?>&amp;handlekey=<?php echo $_GET['handlekey'];?><?php } if(isset($_GET['frommessage'])) { ?>&amp;frommessage<?php } ?>&amp;loginhash=<?php echo $loginhash;?>">
<input type="hidden" name="formhash" value="<?php echo FORMHASH;?>" />
<input type="hidden" name="referer" value="<?php echo dreferer(); ?>" />        
                    	<div class="W_login_form" style="width:280px; margin-top:50px; position:absolute; top:5px; right:10px;">
                    	<div class="u-inplist"><input type="text" class="u-ipt u-input" id="username" style="width:200px;background-image:('static/finabao/fimages/form_login.gif');" name="username" value="" onblur="if(this.value=='') $('enter_name').style.display='';" onkeypress="$('enter_name').style.display='none';" onclick="$('enter_name').style.display='none';" tabindex="1" maxlength="20" autocomplete="off"><span class="enter_name" id="enter_name" style=" position:absolute; left:45px; color:#999; top:10px;" onclick="this.style.display='none'; $('username').focus();">用户名/手机号码/Email地址</span></div>
                    	<div class="u-inplist"><input type="password" name="password" id="password" class="u-ipt u-input" style="width:200px;background-position:0px -50px;" onblur="if(this.value=='') $('enter_psw').style.display='';" onfocus="$('enter_psw').style.display='none';" onclick="$('enter_psw').style.display='none';" tabindex="2" maxlength="20"><span class="enter_psw" id="enter_psw" style=" position:absolute; left:45px; color:#999; top:10px;" onclick="this.style.display='none'; $('password').focus();">请输入密码</span></div>
                    	<div class="u-inplist">
<span class="u-ipt u-input" style=" display:block; width:200px;">
                                	<span class="select_shelter">
                    			<select id="loginquestionid_<?php echo $loginhash;?>" style="_margin-top:10px; " class="u-inselect" name="questionid"<?php if(!$questionexist) { ?> onchange="if($('loginquestionid_<?php echo $loginhash;?>').value > 0) {$('loginanswer_row_<?php echo $loginhash;?>').style.display='';$('loginanswer_<?php echo $loginhash;?>').focus();} else {$('loginanswer_row_<?php echo $loginhash;?>').style.display='none';}"<?php } ?>>
<option value="0"><?php if($questionexist) { ?>安全提问<?php } else { ?>安全提问(未设置请忽略)<?php } ?></option>
<option value="1">母亲的名字</option>
<option value="2">爷爷的名字</option>
<option value="3">父亲出生的城市</option>
<option value="4">您其中一位老师的名字</option>
<option value="5">您个人计算机的型号</option>
<option value="6">您最喜欢的餐馆名称</option>
<option value="7">驾驶执照最后四位数字</option>
</select>
                                   	</span>
</span>
                    	</div>
                            
                    	<div class="u-inplist" id="loginanswer_row_<?php echo $loginhash;?>" <?php if(!$questionexist) { ?> style="display:none"<?php } ?>><input type="text" name="answer" id="loginanswer_<?php echo $loginhash;?>" autocomplete="off" size="30" class="u-ipt u-input" tabindex="1" /></div>
                    	<div class="u-inplist checkbox" style="margin-bottom:5px;">
                            	<a href="javascript:;" class="f-fr" style="margin-right:20px; color:#39C">忘记密码？</a>
<label for="cookietime_<?php echo $loginhash;?>" style="color:#666; font-weight:normal;"><input type="checkbox" class="pc" name="cookietime" id="cookietime_<?php echo $loginhash;?>" tabindex="1" value="2592000" <?php echo $cookietimecheck;?> />&nbsp;&nbsp;记住我的帐号</label>
                            </div>
                            <div class="u-inplist login_btn">
                            	<a href="" class="W_btn_g"><span class="submitStates" style="font-weight:bold; font-size:16px; width:244px; height:32px; padding-top:10px;">登 录</span></a>
                            </div>
                            <div class="u-inplist"><a href="" style="color:#F60; font-size:14px;">还没有金融宝帐号？ 注册一个吧！</a></div>
                        </div>
                                
</form>
        </div>
    </div>
</div>
</div>
</div>
