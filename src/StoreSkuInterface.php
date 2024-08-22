<?php

namespace hVenus\LaravelSaasRetailEleMe;

interface StoreSkuInterface
{
    // 批量新增商品
    public function sku_create_goods($manchant_code, $erp_store_code, $sku_list);

    // 批量修改商品
    public function sku_update_goods($manchant_code, $erp_store_code, $sku_list);

    // 批量查询门店商品
    public function store_goods_query($manchant_code, $erp_store_code, $sku_code_list, $page_size, $page_no);

    // 单个商品价格修改
    public function sku_update_price($manchant_code, $erp_store_code, $sku_code, $price);

    // 单个商品价格修改
    public function sku_update_status($manchant_code, $erp_store_code, $sku_code, $status);

    // 批量商品价格修改
    public function sku_update_price_batch($manchant_code, $erp_store_code, $sku_list);

    // 批量商品状态修改
    public function sku_update_status_batch($manchant_code, $erp_store_code, $sku_list);

    // 批量查询门店商品并下发到渠道
    public function goods_channel_publish_bath($manchant_code, $erp_store_code, $channel_type, $out_shop_id, $page_size, $page_no, $sku_code_list = null);
}
