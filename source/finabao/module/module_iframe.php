<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: home.php 32932 2013-03-25 06:53:01Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$action = in_array(getgpc('act'), array('login', 'lostpassword')) ? getgpc('act') : 'login';
require_once libfile('function/member');
finaload('class/member_login');


if($action == 'login'){

	if(!$_G['uid'])
	{
	if(!submitcheck('loginsubmit', 1)) {
		include_once libfile('function/member');
		$referer = dreferer();
		$loginhash = 'L'.random(4);

		if($_G['cookie']['lastcheckfeed']){
			$lastactivity	=	explode("|", $_G['cookie']['lastcheckfeed']);
			$lastactivity	=	dgmdate($lastactivity[1], "Y-m-d H:i:s");
		}


		include template('member/'.$action.'_iframe');
	} else {

		loaducenter();
		include_once libfile('function/member');
		include_once libfile('class/helper_output');

		$returncode		=	0;

		$return		=	array(
			'-6'	=>	array('return' => '-6', 'message' => '安全码输入有误',				'reload' => false),
			'-5'	=>	array('return' => '-5', 'message' => lang('message', 'profile_passwd_illegal'),			'reload' => false),
			'-4'	=>	array('return' => '-4', 'message' => lang('message', 'activate_succeed'),					'reload' => true),
			'-3'	=>	array('return' => '-3', 'message' => lang('message', 'login_invalid'),					'reload' => false),
			'-2'	=>	array('return' => '-2', 'message' => lang('message', 'login_strike'), 					'reload' => false),
			'-1'	=>	array('return' => '-1', 'message' => lang('message', 'login_password_invalid'), 			'reload' => false),
			'1'		=>	array('return' => '1', 'message' => lang('message', 'login_succeed_inactive_member'), 	'reload' => true),
			'2'		=>	array('return' => '2', 'message' => lang('message', 'login_succeed'),					'reload' => true),
		);
		if(!($_G['member_loginperm'] = logincheck($_GET['username']))) {
			$returncode	=	-2;
			helper_output::json($return[$returncode]);
		}
		$loginhash	=	getgpc('loginhash');

		if($_GET['fastloginfield']) {
			$_GET['loginfield'] = $_GET['fastloginfield'];
		}
		$_G['uid'] = $_G['member']['uid'] = 0;
		$_G['username'] = $_G['member']['username'] = $_G['member']['password'] = '';
		if(!getgpc('p_'.$loginhash) || getgpc('p_'.$loginhash) != addslashes(getgpc('p_'.$loginhash))) {
			$returncode	=	-5;
		}

		if(strlen(getgpc('u_'.$loginhash)) == 11 && preg_match("/^1[3|5|8][0-9]\d{4,8}$/", getgpc('u_'.$loginhash))){
			$loguid = DB::result_first('SELECT uid FROM %t WHERE mobile=%s', array('common_member_profile', getgpc('u_'.$loginhash)));
		} elseif(isemail(getgpc('u_'.$loginhash))) {
			$loguid = DB::result_first('SELECT uid FROM %t WHERE email=%s', array('common_member', getgpc('u_'.$loginhash)));
		} else{
			$loguid = DB::result_first('SELECT uid FROM %t WHERE username=%s', array('common_member', getgpc('u_'.$loginhash)));
		}

		if(!$loguid){
			$returncode	=	-1;
			helper_output::json($return[$returncode]);
			exit();
		}
		$result = userlogin($loguid, getgpc('p_'.$loginhash), getgpc('a_'.$loginhash) ? 1 : 0, getgpc('a_'.$loginhash), 'uid', $_G['clientip']);

		$uid = $result['ucresult']['uid'];
		if($result['status'] == -1) {
			$init_arr = explode(',', $_G['setting']['initcredits']);
			$groupid = $_G['setting']['regverify'] ? 8 : $_G['setting']['newusergroupid'];

			C::t('common_member')->insert($uid, $result['ucresult']['username'], md5(random(10)), $result['ucresult']['email'], $_G['clientip'], $groupid, $init_arr);
			$result['member'] = getuserbyuid($uid);
			$result['status'] = 1;
		}


		if($result['status'] > 0) {
			setloginstatus($result['member'], $_GET['cookietime'] ? 2592000 : 0);
			checkfollowfeed();

			if($_G['member']['lastip'] && $_G['member']['lastvisit']) {
				dsetcookie('lip', $_G['member']['lastip'].','.$_G['member']['lastvisit']);
			}
			C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
			$ucsynlogin = $_G['setting']['allowsynlogin'] ? uc_user_synlogin($_G['uid']) : '';

			if($invite['id']) {
				$result = C::t('common_invite')->count_by_uid_fuid($invite['uid'], $uid);
				if(!$result) {
					C::t('common_invite')->update($invite['id'], array('fuid'=>$uid, 'fusername'=>$_G['username']));
					updatestat('invite');
				} else {
					$invite = array();
				}
			}
			if($invite['uid']) {
				require_once libfile('function/friend');
				friend_make($invite['uid'], $invite['username'], false);
				dsetcookie('invite_auth', '');
				if($invite['appid']) {
					updatestat('appinvite');
				}
			}

			$param = array(
				'username' => $result['ucresult']['username'],
				'usergroup' => $_G['group']['grouptitle'],
				'uid' => $_G['member']['uid'],
				'groupid' => $_G['groupid'],
				'syn' => $ucsynlogin ? 1 : 0
			);

			$extra = array(
				'showdialog' => true,
				'locationtime' => true,
				'extrajs' => $ucsynlogin
			);

			$returncode = $_G['groupid'] == 8 ? 1 : 2;
			$sitevars	=	array('{username}' => $result['ucresult']['username'], '{usergroup}' => $_G['group']['grouptitle']);
			$return[2]['message']	=	str_replace(array_keys($sitevars), array_values($sitevars), $return[2]['message']);

		} else {
			$password = preg_replace("/^(.{".round(strlen(getgpc('p_'.$loginhash)) / 4)."})(.+?)(.{".round(strlen(getgpc('p_'.$loginhash)) / 6)."})$/s", "\\1***\\3", getgpc('p_'.$loginhash));
			$errorlog = dhtmlspecialchars(
				TIMESTAMP."\t".
				($result['ucresult']['username'] ? $result['ucresult']['username'] : getgpc('u_'.$loginhash))."\t".
				$password."\t".
				"Ques #".intval(getgpc('q_'.$loginhash))."\t".
				$_G['clientip']);
			writelog('illegallog', $errorlog);


			$fmsg = $result['ucresult']['uid'] == '-3' ? (empty($_GET['q_'.$loginhash]) || $answer == '' ? 'login_question_empty' : 'login_question_invalid') : 'login_invalid';
			if($fmsg	==	'login_question_empty'){
				$returncode	=	-6;
				helper_output::json($return[$returncode]);
			}
			loginfailed(getgpc('u_'.$loginhash));
			if($_G['member_loginperm'] > 1) {
				$returncode	=	-3;
				$sitevars	=	array('{loginperm}' => $_G['member_loginperm'] - 1);
				$return[$returncode]['message']	=	str_replace(array_keys($sitevars), array_values($sitevars), $return[$returncode]['message']);
			} elseif($_G['member_loginperm'] == -1) {
				$returncode	=	-1;
			} else {
				$returncode	=	-2;
			}

		}
		helper_output::json($return[$returncode]);
	}

	} else {

		$settle =	C::t('finabao_settle')->settle_by_uid($_G['uid']);
		include template('finabao/iframe_login');
	}


}



?>