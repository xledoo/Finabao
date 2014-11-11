<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 
0
|| checktplrefresh('./template/finabao/common/header.htm', './template/finabao/common/header_common.htm', 1415686001, '2', './data/template/2_2_common_header_member_register.tpl.php', './template/finabao', 'common/header_member_register')
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<?php if($_G['config']['output']['iecompatible']) { ?><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE<?php echo $_G['config']['output']['iecompatible'];?>" /><?php } ?>
<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> 让理财轻松一点</title>
<?php echo $_G['setting']['seohead'];?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />
<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } if(empty($nobbname)) { ?>,<?php echo $_G['setting']['bbname'];?><?php } ?>" />
<meta name="generator" content="Discuz! <?php echo $_G['setting']['version'];?>" />
<meta name="author" content="xledoo@qq.com" />
<meta name="copyright" content="2013 Yunnan YunJing E-commerce Co., Ltd." />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<base href="<?php echo $_G['siteurl'];?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_2_common.css?<?php echo VERHASH;?>" /><?php if($_G['uid'] && isset($_G['cookie']['extstyle']) && strpos($_G['cookie']['extstyle'], TPLDIR) !== false) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['cookie']['extstyle'];?>/style.css" /><?php } elseif($_G['style']['defaultextstyle']) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['style']['defaultextstyle'];?>/style.css" /><?php } ?><script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>', DYNAMICURL = '<?php echo $_G['dynamicurl'];?>';</script>
    <script src="static/finabao/javascript/jquery-1.10.2.min.js?<?php echo VERHASH;?>" type="text/javascript"></script>
    <script src="static/finabao/bootstrap/js/bootstrap.min.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="<?php echo $_G['setting']['jspath'];?>common.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="static/finabao/javascript/respond.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php if(empty($_GET['diy'])) { $_GET['diy'] = '';?><?php } if(!isset($topic)) { $topic = array();?><?php } ?><meta name="application-name" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-tooltip" content="<?php echo $_G['setting']['bbname'];?>" />
<?php if($_G['setting']['portalstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['1']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G['siteurl'].'portal.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/portal.ico" /><?php } ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['2']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G['siteurl'].'forum.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/bbs.ico" />
<?php if($_G['setting']['groupstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['3']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G['siteurl'].'group.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/group.ico" /><?php } if(helper_access::check_module('feed')) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['4']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G['siteurl'].'home.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/home.ico" /><?php } if($_G['basescript'] == 'forum' && $_G['setting']['archiver']) { ?>
<link rel="archives" title="<?php echo $_G['setting']['bbname'];?>" href="<?php echo $_G['siteurl'];?>archiver/" />
<?php } if(!empty($rsshead)) { ?><?php echo $rsshead;?><?php } if(widthauto()) { ?>
<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_widthauto.css?<?php echo VERHASH;?>" />
<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
<?php } if($_G['basescript'] == 'forum' || $_G['basescript'] == 'group') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>forum.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'home' || $_G['basescript'] == 'userapp') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>home.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'portal') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<link rel="stylesheet" type="text/css" id="diy_common" href="data/cache/style_<?php echo STYLEID;?>_css_diy.css?<?php echo VERHASH;?>" />
<?php } ?>
    <!--[if IE]> <script src=”http://html5shiv.googlecode.com/svn/trunk/html5.js”></script> <![endif]-->
    <link rel="stylesheet" href="static/bootstrap/css/bootstrap.css?<?php echo VERHASH;?>" />
    <link rel="stylesheet" href="static/finabao/global.css?<?php echo VERHASH;?>" />

</head>
<body id="nv_<?php echo $_G['basescript'];?>" class="pg_<?php echo CURMODULE;?><?php if($_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)) { ?> <?php echo $cat['bodycss'];?><?php } ?>" onkeydown="if(event.keyCode==27) return false;">
<div id="append_parent"></div><div id="ajaxwaitid"></div>


<div class="m-header">
<div class="m-topbar">
    	<div class="container">
    		<ul class="m-navlist-warp f-fr">
<?php if(!$_G['uid']) { ?>
<li><a href="member.php?mod=logging&amp;action=login&amp;referer=<?php echo rawurlencode($dreferer); ?>" onClick="showWindow('login', this.href);return false;" class="xi2">登陆</a></li>
<li><a href="member.php?mod=<?php echo $_G['setting']['regname'];?>">注册新帐号</a></li>
<?php } else { ?>
<li><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" title="访问我的空间"><?php echo $_G['member']['username'];?></a></li>
<li class="visible-lg"><a href="home.php?mod=spacecp">设置</a></li>
<li class="visible-lg"><a href="home.php?mod=space&amp;do=pm" id="pm_ntc"<?php if($_G['member']['newpm']) { ?> class="new"<?php } ?>>消息</a></li>
<li class="visible-lg"><a href="home.php?mod=space&amp;do=notice" id="myprompt" onMouseOver="showMenu({'ctrlid':'myprompt'});">提醒<?php if($_G['member']['newprompt']) { ?> <span class="label label-danger badge"><?php echo $_G['member']['newprompt'];?></span><?php } ?></a><span id="myprompt_check"></span></li>
<?php if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
<li class="visible-lg"><a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a></li>
<?php } if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
<li class="visible-lg"><a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a></li>
<?php } if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?>
<li class="visible-lg"><a href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank">云平台</a></li>
<?php } if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
<li><a href="admin.php" target="_blank">管理中心</a></li>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?>
<li><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a></li>
<?php } ?>
            </ul>
        	<ul class="f-fl">
        		<li><a href="">金融宝首页</a></li>
<li class="active visible-lg" style="background-color:#ff8500;"><a href="http://wp.qq.com/wpa/qunwpa?idkey=23b30a1291339761b9b4f8cf6da7d639c85f4fc7cd870ed6923d97c1fd269c90" target="_blank">加入官方QQ群</a></li>
<li class="visible-lg"><a href="javascript:void(0);">服务电话: 0874-3337898</a></li>
            </ul>
        </div>
    </div>
    <div class="m-topnav">
    	<div class="container f-pr">
    		<div class="f-fr">
<ul class="m-navlist"><?php if(is_array($_G['setting']['navs'])) foreach($_G['setting']['navs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?><li <?php if($mnid == $nav['navid']) { ?>class="a" <?php } ?><?php echo $nav['nav'];?>></li><?php } } ?>
</ul>
            </div>
    		<div class="m-logo f-fl">
            	<h1>金融宝 - 绿色金融 健康生活 让理财轻松一点</h1>
            	<a href="https://www.finabao.com/index.php"><img width="247" height="42" alt="金融宝 - 绿色金融 健康生活 让理财轻松一点" src="static/finabao/fimages/logo.png"><span class="sub-logo"></span></a>
            </div>
</div>
    </div>
</div>