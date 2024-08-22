<?php

namespace hVenus\LaravelSaasRetailEleMe;

interface StoreOrderInterface
{
    // 正向订单查询
    public function order_search($order_id);

    // 逆向订单查询
    public function refunded_order_search($order_id);

    // 订单主动退款
    public function order_refund($merchant_code, $erp_store_code, $order_id, $reason, $whole_refund, $refund_detail);

    // 订单拣货完成
    public function order_picking_completed($erp_store_code, $order_id, $merchant_code);

    // 订单自提核销
    public function order_self_pickup_wiped_out($pick_up_code, $qr_code);
}
