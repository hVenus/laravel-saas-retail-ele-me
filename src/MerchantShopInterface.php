<?php

namespace hVenus\LaravelSaasRetailEleMe;

interface MerchantShopInterface
{
    // 通过外部渠道id查询渠道店
    public function merchant_shop_search($merchant_code, $erp_store_code, $channel_type, $out_shop_id);
}
