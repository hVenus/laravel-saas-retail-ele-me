<?php

namespace hVenus\LaravelSaasRetailEleMe;

interface StoreSkuStock
{
    // 库存批量更新
    public function sku_stock_update($manchant_code, $erp_store_code, $sku_list);
}
