<?php
C::t('finabao_settle_member')->restore($_G['uid']);
//C::t('finabao_settle_member')->update_paypass($_G['uid'], 'zmin!@#', '!@#zmin');
debug(C::t('finabao_settle_member')->verify_md5($_G['uid']));
?>