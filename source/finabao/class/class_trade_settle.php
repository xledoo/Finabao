<?php
/**
 * 交易结算处理
 */
class TradeSettle
{

    /**
     * 当月流水表
     */
    var $_setable   =   '';

    public function __construct()
    {
        $this->_setable =   'plugin_finabao_trade_settle';
    }


    public function topup($order)
    {

        $trade  =   DB::fetch_first("SELECT * FROM ".DB::table('plugin_finabao_trade_topup')." WHERE trade='$order' AND result='1' AND entertime>'0' AND status='1' AND settled='0'");

        if($trade){

            $member =   DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid=".$trade['uid']);
            $data   =   array(
                'uid'       => $member['uid'],
                'username'  => $member['username'],
                'trade'     => $trade['trade'],
                'type'      => 'topup',
                'freeze'    => 0,
                'money'     => $trade['deal'],
                'dateline'  => TIMESTAMP
            );

            $data['md5hash']    =   md5(serialize($data));
            $data['auth']       =   authcode(serialize($data), 'ENCODE', $trade['trade']);

            DB::insert($this->_setable, $data);
            DB::update('plugin_finabao_trade_topup', array('status' => 2, 'settled' => 1), array('trade' => $order, 'status' => 1, 'result' => 1));
            $logdata    =   array('uid' => $member['uid'], 'trade' => $order, 'dateline' => TIMESTAMP, 'status' => 2);
            $logdata['auth']   =   authcode(serialize($logdata), 'ENCODE', $order);
            DB::insert('plugin_finabao_trade_topup_log', $logdata);

        } else {
            writelog('trade_topup_error', TIMESTAMP.' TradeSettle::topup::'.$order);
        }
    }

    public function settle($uid)
    {
        $typearr    =   array('usable', 'freeze', 'topup', 'refund', 'settle');

        $mytrade    =   DB::fetch_all("SELECT * FROM %t WHERE uid='%d'", array($this->_setable, $uid));
        $data       =   array();
        $settle     =   array();
        for($i=0; $i < count($mytrade); $i++) {
            for ($j=0; $j < count($typearr); $j++) {
                if($mytrade[$i]['type'] == $typearr[$j]){
                    $data[$typearr[$j]] = finanum($data[$typearr[$j]]+$mytrade[$i]['money']);
                }
            }
        }


        $data['usable']     =   finanum($data['topup'] + $data['settle'] - $data['refund'] - $data['freeze']);
        $data['freeze']     =   $data['freeze'] == 0 ? '0.00' : $data['freeze'];
        $data['total']      =   finanum($data['usable'] + $data['freeze']);
        return $data;
    }


    public function unfreeze($order)
    {
        $freezetrade = DB::fetch_first("SELECT * FROM %t WHERE trade=%s AND type=%s AND freeze=%d", array('plugin_finabao_trade_settle', $order, 'freeze', 1));

        if($freezetrade)
        {
            $data   =   array(
                'uid'       => $freezetrade['uid'],
                'username'  => $freezetrade['username'],
                'trade'     => $freezetrade['trade'],
                'type'      => 'refund',
                'freeze'    => 0,
                'money'     => finanum($freezetrade['deal']),
                'dateline'  => TIMESTAMP
            );

            $data['md5hash']    =   md5(serialize($data));
            $data['auth']       =   authcode(serialize($data), 'ENCODE', $freezetrade['trade']);
            return DB::update('plugin_finabao_trade_settle',
                array('type' => 'refund', 'freeze' => '0', 'dateline' => $data['dateline'], 'md5hash' => $data['md5hash'], 'auth' => $data['auth']),
                array('trade' => $order, 'type' => 'freeze', 'freeze' => '1')
            );
        }
        return false;
    }






}


?>