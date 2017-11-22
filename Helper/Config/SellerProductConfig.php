<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 9/8/17
 * Time: 11:12 AM
 */

namespace AWstreams\Marketplace\Helper\Config;


class SellerProductConfig extends GlobalConfig
{


    public function getPurchaseLimit()
    {
        return $this->getConfig('marketplace/seller_products_setting/allowed_product_qty_on_product_purchase_for_customer');

    }


    public function get($param)
    {
        return $this->getConfig('marketplace/seller_products_setting/' . $param);

    }
}