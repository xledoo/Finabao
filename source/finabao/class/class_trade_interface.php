<?php


interface   trade_interface
{
    /**
     * 构造函数
     */
    function __construct();
    /**
     * 创建订单号
     */
    public function creadeOrder();
    /**
     * 提交订单信息到接口
     */
    public function submitOrder($money);
    /**
     * 储存订单信息到数据库
     */
    public function saveOrder();
    /**
     * 确认订单状态
     */
    public function enterOrder($order);
    /**
     * 验证接口反馈信息
     */
    public function varifyReturn();
    /**
     * 对订单进行验证
     */
    public function verifyOrder();
    /**
     * 通过密钥验证
     */
    public function verifyKey($key);

    public function returnMember();
    public function returnSystem();

    /**
     * 支持银行
     */
    static public function bank();
}

?>