<?php

$passage    =   getgpc('passage') ? getgpc('passage') : exit();
$referer    =   dreferer();
finaload('class/trade_'.$passage);
$trade  =   'Trade_'.getgpc('passage');
$trade  =   new $trade;

if(getgpc('action') == 'topup'){

    $trade->returnSystem();


} elseif(getgpc('action') == 'trade'){

    $trade->returnMember();

}
?>