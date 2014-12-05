<?php


if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class table_finabao_smsender extends discuz_table {

    public function __construct() {
        $this->_table = 'finabao_smsender';
        $this->_pk = 'id';

        parent::__construct();
    }


}

?>