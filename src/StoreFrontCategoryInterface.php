<?php

namespace hVenus\LaravelSaasRetailEleMe;

interface StoreFrontCategoryInterface
{

    // 门店创建单条前台类目
    public function store_category_create($manchant_code, $erp_store_code, $category_name, $category_code, $category_parent_name = null, $rank = null);

    // 门店更新单条前台类目
    public function store_category_update($manchant_code, $erp_store_code, $category_name = null, $category_code = null, $category_id = null, $rank = null);

    // 门店删除单条前台类目
    public function store_category_delete($manchant_code, $erp_store_code, $category_id = null, $category_code = null);

    // 门店查询前台类目树
    public function store_category_query($manchant_code, $erp_store_code);
}
