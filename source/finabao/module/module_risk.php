<?php

$intlist    =   C::t('finabao_risk_integrity')->query_for_table();
$signarr    =   array('A' => 'success', 'B' => 'info', 'C' => 'warning', 'D' => 'danger');


include template('risk/index');
?>