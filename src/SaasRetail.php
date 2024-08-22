<?php

namespace hVenus\LaravelSaasRetailEleMe;

class SaasRetail implements MerchantShopInterface, StoreFrontCategoryInterface, StoreOrderInterface, StoreSkuStock, StoreSkuInterface
{
    private $app_key = '';
    private $app_secret = '';
    private $host = 'https://api-be.ele.me';

    public function __construct($appKey, $appSecret)
    {
        $this->app_key = $appKey;
        $this->app_secret = $appSecret;
    }

    // 设置翱象接口服务器地址
    public function setServerHost($host)
    {
        $this->host = $host;
    }

    public function fetch($cmd, $body)
    {
        return Util::request($this->host, $this->app_key, $this->app_secret, $cmd, $body);
    }

    // ========================================================================
    // 前台类目

    // 门店创建单条前台类目
    public function store_category_create($manchant_code, $erp_store_code, $category_name, $category_code, $category_parent_name = null, $rank = null)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'category_name' => $category_name,
            'category_code' => $category_code,
        ];
        if ($category_parent_name != null) {
            $body['category_parent_name'] = $category_parent_name;
        }
        if ($rank != null) {
            $body['rank'] = $rank;
        }
        return $this->fetch('saas.store.front.category.create', $body);
    }

    // 门店更新单条前台类目
    public function store_category_update($manchant_code, $erp_store_code, $category_name = null, $category_code = null, $category_id = null, $rank = null)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'category_name' => $category_name,
            'category_code' => $category_code,
        ];
        if ($category_name != null) {
            $body['category_name'] = $category_name;
        }
        if ($category_id != null) {
            $body['category_id'] = $category_id;
        } else if ($category_code != null) {
            $body['category_code'] = $category_code;
        } else {
            return [
                'errno' => -1,
                'error' => 'category_id 与 category_code 两者传其一',
            ];
        }
        if ($rank != null) {
            $body['rank'] = $rank;
        }
        return $this->fetch('saas.store.front.category.update', $body);
    }

    // 门店删除单条前台类目
    public function store_category_delete($manchant_code, $erp_store_code, $category_id = null, $category_code = null)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
        ];
        if ($category_id != null && $category_code != null) {
            return [
                'errno' => -1,
                'error' => 'category_id 与 category_code 两者传其一',
            ];
        }
        if ($category_id != null) {
            $body['category_id'] = $category_id;
        }
        if ($category_code != null) {
            $body['category_code'] = $category_code;
        }
        return $this->fetch('saas.store.front.category.delete', $body);
    }

    // 门店查询前台类目树
    public function store_category_query($manchant_code, $erp_store_code)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
        ];
        return $this->fetch('saas.store.front.category.tree.query', $body);
    }


    // ========================================================================
    // 商品

    // 批量新增商品
    // https://open-retail.ele.me/#/apidoc/me.ele.retail:saas.sku.create.goods.batch-3?aopApiCategory=item_manage&type=item_all
    public function sku_create_goods($manchant_code, $erp_store_code, $sku_list)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_list' => $sku_list,
        ];

        return $this->fetch('saas.sku.create.goods.batch', $body);
    }

    // 批量修改商品
    // https://open-retail.ele.me/#/apidoc/me.ele.retail:saas.sku.create.goods.batch-3?aopApiCategory=item_manage&type=item_all
    public function sku_update_goods($manchant_code, $erp_store_code, $sku_list)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_list' => $sku_list,
        ];

        return $this->fetch('saas.sku.create.goods.batch', $body);
    }

    // 批量查询门店商品
    public function store_goods_query($manchant_code, $erp_store_code, $sku_code_list, $page_size, $page_no)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_code_list' => $sku_code_list,
            'page_size' => $page_size,
            'page_no' => $page_no,
        ];

        return $this->fetch('saas.goods.store.query.batch', $body);
    }

    // 单个商品价格修改
    public function sku_update_price($manchant_code, $erp_store_code, $sku_code, $price)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_code' => $sku_code,
            'price' => $price,
        ];

        return $this->fetch('saas.sku.update.price.one', $body);
    }

    // 单个商品价格修改
    public function sku_update_status($manchant_code, $erp_store_code, $sku_code, $status)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_code' => $sku_code,
            'status' => $status,
        ];

        return $this->fetch('saas.sku.update.status.one', $body);
    }

    // 批量商品价格修改
    public function sku_update_price_batch($manchant_code, $erp_store_code, $sku_list)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_list' => $sku_list,
        ];

        return $this->fetch('saas.sku.update.price.batch', $body);
    }

    // 批量商品状态修改
    // 3下架，4上架
    public function sku_update_status_batch($manchant_code, $erp_store_code, $sku_list)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_list' => $sku_list,
        ];
        return $this->fetch('saas.sku.update.status.batch', $body);
    }

    // 批量查询门店商品并下发到渠道
    public function goods_channel_publish_bath($manchant_code, $erp_store_code, $channel_type, $out_shop_id, $page_size, $page_no, $sku_code_list = null)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'channel_type' => $channel_type,
            'out_shop_id' => $out_shop_id,
            'page_size' => $page_size,
            'page_no' => $page_no,
        ];
        if ($sku_code_list != null) {
            $body['sku_code_list'] = $sku_code_list;
        }
        return $this->fetch('saas.goods.channel.publish.batch', $body);
    }

    // ========================================================================
    // 库存

    // 库存批量更新
    // sku_list (数组长度 < 20)
    // [
    //    [ sku_code: string, quantity: long ]
    // ]
    public function sku_stock_update($manchant_code, $erp_store_code, $sku_list)
    {
        $body = [
            'manchant_code' => $manchant_code,
            'erp_store_code' => $erp_store_code,
            'sku_list' => $sku_list,
        ];

        return $this->fetch('saas.sku.stock.update.batch', $body);
    }


    // ========================================================================
    // 商户

    // 通过外部渠道id查询渠道店
    public function merchant_shop_search($merchant_code, $erp_store_code, $channel_type, $out_shop_id)
    {
        $body = [
            'merchant_code' => $merchant_code,
            'erp_store_code' => $erp_store_code,
            'channel_type' => $channel_type,
            'out_shop_id' => $out_shop_id,
        ];

        return $this->fetch('saas.merchant.shop.query', $body);
    }


    // ========================================================================
    // 订单

    // 正向订单查询
    public function order_search($order_id)
    {
        $body = [
            'order_id' => $order_id
        ];

        return $this->fetch('saas.order.get', $body);
    }

    // 逆向订单查询
    public function refunded_order_search($order_id)
    {
        $body = [
            'refund_id' => $order_id
        ];

        return $this->fetch('saas.reverse.order.get', $body);
    }

    // 订单主动退款
    // refund_detail:
    // [
    //    [ sub_order_id: long, refund_amount: integer ]
    // ]
    public function order_refund($merchant_code, $erp_store_code, $order_id, $reason, $whole_refund, $refund_detail)
    {
        $body = [
            'order_id' => $order_id,
            'merchant_code' => $merchant_code,
            'erp_store_code' => $erp_store_code,
            'reason' => $reason,
            'whole_refund' => $whole_refund,
            'refund_detail' => $refund_detail,
        ];

        return $this->fetch('saas.reverse.order.apply', $body);
    }

    // 订单拣货完成
    public function order_picking_completed($erp_store_code, $order_id, $merchant_code)
    {
        $body = [
            'order_id' => $order_id,
            'erp_store_code' => $erp_store_code,
            'merchant_code' => $merchant_code,
        ];

        return $this->fetch('saas.order.pickcomplete', $body);
    }

    // 订单自提核销
    public function order_self_pickup_wiped_out($pick_up_code, $qr_code)
    {
        $body = [
            'erp_store_code' => '1',
            'merchant_code' => 'LDDJCS',
            'pick_up_code' => $pick_up_code,
            'qr_code' => $qr_code,
        ];

        return $this->fetch($this->host, 'saas.order.selfpick.checkout', $body);
    }
}
