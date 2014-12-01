<?php

finaload('class/borrow_base');

class Borrow implements BorrowBase
{

    /**
     * 创建一个借款信息
     */
    public create($uid, $type, $title, $money, $line, $rate)
    {

        DB::insert('plugin_finabao_borrow');
    }

}


?>