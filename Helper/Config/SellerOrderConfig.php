<?php
/**
 * SellerOrder
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Helper\Config;


class SellerOrderConfig extends GlobalConfig
{

    public function get($param)
    {
        return $this->getConfig('marketplace/seller_order_setting/' . $param);
    }
}