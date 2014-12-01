<?php



/**
 * 支付通道缓存更新
 * 2013101501-25
 */

function updatecache_members($update = fasle)
{
    global $_G;
    if(0 == count($_G['cache']['members']) || $update){
        $members   =   DB::fetch_all("SELECT * FROM %t m LEFT JOIN %t p ON p.uid=m.uid LEFT JOIN %t s ON s.uid=m.uid LEFT JOIN %t c ON c.uid=m.uid", array('common_member', 'common_member_profile', 'common_member_status', 'common_member_count'));
        foreach ($members as $key => $value) {
            $member[$value['uid']]    =   $value;
        }
        savecache('members', $member);
        loadcache('members');
    }

    return $_G['cache']['members'];
}


function finacache($table, $cachename, $keyfield = '', $update = false)
{
    global $_G;
    if(!isset($_G['cache'][$cachename]) || $update){
        $cachedatas =   DB::fetch_all("SELECT * FROM %t", array($table));
        $cachedata  =   array();
        if($keyfield){
            foreach ($cachedatas as $k => $value) {
                $cachedata[$value[$keyfield]]    =   $value;
            }
        } else {
            $cachedata = $cachedatas;
        }
        savecache($cachename, $cachedata);
        loadcache($cachename);
    }
    return $_G['cache'][$cachename];
}

function finahash($specialadd = '')
{
	global $_G;
	$hashadd = defined('IN_ADMINCP') ? 'Only For Discuz! Admin Control Panel' : '';
	return md5(md5(substr($_G['timestamp'], 0, -7).$_G['username'].$_G['uid'].$_G['authkey'].$hashadd.$specialadd));
}

function formcheck($var, $hash = true, $allowget = 0, $seccodecheck = 0, $secqaacheck = 0)
{
	if($hash) {
		if(getgpc('hash') != finahash()){
			return FALSE;
		}
	}
	if(!getgpc($var)) {
		return FALSE;
	} else {
		return helper_form::submitcheck($var, $allowget, $seccodecheck, $secqaacheck);
	}
}

function finamodule($mod)
{
    global $_G;
    return $_G['siteurl'].'index.php?mod='.$mod;
}



function finaload($libname)
{
    global $_G;
    require_once file_exists(libfile($libname, 'finabao')) ? libfile($libname, 'finabao') : showmessage('undefined_action');
}

function finanum($num, $qs = true)
{
    $qsnum    =   floor($num*100);
    return $qs ? finanum($qsnum/100, false) : sprintf("%.2f", $num);
}

function tofloat($num, $sw = false) {
    return $sw ? sprintf("%.2f", $num) : substr(sprintf("%.7f", $num), 0, -5);
}


function checkpaypass($uid, $paypass = 0)
{
    return $paypass ? DB::result_first("SELECT paypass FROM %t WHERE uid=%d AND paypass=%s", array('finabao_settle_member', $uid, md5($paypass))) : DB::result_first("SELECT paypass FROM %t WHERE uid=%d", array('finabao_settle_member', $uid));
}

function SMSFund($passage, $mobile, $message, $action = '')
{
	$smspass	=	array(
		'smsender'	=>	array(
			'username'	=>	'xledoo',
			'password'	=>	'zmin821001',
			'charset'	=>	'utf8',
			'interface'	=>	'http://api.chanyoo.cn/{charset}/interface/send_sms.aspx?username={username}&password={password}&receiver={mobile}&content={message}',
		),
		'smscenter'	=>	array(
			'username'	=>	'xledoo',
			'password'	=>	'zmin821001',
			'charset'	=>	'utf8',
			'interface'	=>	'http://www.139000.com/send/gsend.asp?name={username}&pwd={password}&dst={mobile}&msg={message}',
		),
	);

	finaload('class/'.strtolower($passage));
	$SMS	=	new $passage($smspass[strtolower($passage)]['username'], $smspass[strtolower($passage)]['password'], $smspass[strtolower($passage)]['charset'], $smspass[strtolower($passage)]['interface']);
	return $SMS->SendSMS($mobile, $message, $action);
}



function finadate($timestamp, $format = 'dt', $timeoffset = '9999', $uformat = '') {
    global $_G;

    $format == 'u' && !$_G['setting']['dateconvert'] && $format = 'dt';
    static $dformat, $tformat, $dtformat, $offset, $lang;
    if($dformat === null) {
        $dformat = getglobal('setting/dateformat');
        $tformat = getglobal('setting/timeformat');
        $dtformat = $dformat.' '.$tformat;
        $offset = getglobal('member/timeoffset');
        $sysoffset = getglobal('setting/timeoffset');
        $offset = $offset == 9999 ? ($sysoffset ? $sysoffset : 0) : $offset;
        $lang = lang('core', 'date');
    }
    $timeoffset = $timeoffset == 9999 ? $offset : $timeoffset;
    $timestamp += $timeoffset * 3600;
    $format = empty($format) || $format == 'dt' ? $dtformat : ($format == 'd' ? $dformat : ($format == 't' ? $tformat : $format));

    if($format == 'u') {
        $todaytimestamp = TIMESTAMP - (TIMESTAMP + $timeoffset * 3600) % 86400 + $timeoffset * 3600;
        $s = gmdate(!$uformat ? $dtformat : $uformat, $timestamp);
        $time = TIMESTAMP + $timeoffset * 3600 - $timestamp;
        if($timestamp >= $todaytimestamp) {
            if($time > 3600) {
                $return = intval($time / 3600).'&nbsp;'.$lang['hour'].$lang['before'];
            } elseif($time > 1800) {
                $return = $lang['half'].$lang['hour'].$lang['before'];
            } elseif($time > 60) {
                $return = intval($time / 60).'&nbsp;'.$lang['min'].$lang['before'];
            } elseif($time > 0) {
                $return = $time.'&nbsp;'.$lang['sec'].$lang['before'];
            } elseif($time == 0) {
                $return = $lang['now'];
            } else {
                $return = $s;
            }
            if($time >=0 && !defined('IN_MOBILE')) {
                $return = '<span title="'.$s.'">'.$return.'</span>';
            }
        } elseif(($days = intval(($todaytimestamp - $timestamp) / 86400)) >= 0 && $days < 7) {
            if($days == 0) {
                $return = $lang['yday'].'&nbsp;'.gmdate($tformat, $timestamp);
            } elseif($days == 1) {
                $return = $lang['byday'].'&nbsp;'.gmdate($tformat, $timestamp);
            } else {
                $return = ($days + 1).'&nbsp;'.$lang['day'].$lang['before'];
            }
            if(!defined('IN_MOBILE')) {
                $return = '<span title="'.$s.'">'.$return.'</span>';
            }
        } else {
            $return = $s;
        }
        return $return;
    } else {
        return gmdate($format, $timestamp);
    }
}
