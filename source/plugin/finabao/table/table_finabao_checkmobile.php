<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_finabao_checkmobile extends discuz_table {

    public function __construct() {
        $this->_table = 'finabao_checkmobile';
        $this->_pk = 'mobile';

        parent::__construct();
    }

    public function check($mobile, $sign){
        return DB::result_first("SELECT mobile FROM %t WHERE mobile=%s AND signcode=%s", array($this->_table, $mobile, $sign));
    }

    public function check_sendtime($mobile, $sign){
        $sendtime = DB::result_first("SELECT dateline FROM %t WHERE mobile=%s AND signcode=%s", array($this->_table, $mobile, $sign));
        return !empty($sendtime) ? TIMESTAMP - $sendtime : false;
    }

    public function add($mobile, $sign)
    {
        global $_G;
        self::del_by_mobile($mobile);
        $data = array(
            'dateline'  =>  TIMESTAMP,
            'signcode'  =>  $sign,
            'ipaddress' =>  $_G['clientip'],
            'mobile'    =>  $mobile
        );
        return DB::insert($this->_table, $data, false, true);
    }

    public function del_by_mobile($mobile){
        return DB::delete($this->_table, array('mobile' => $mobile));
    }
}

?>