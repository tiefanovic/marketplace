<?php
/**
 * InventoryConfig
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Helper\Config;


class InventoryConfig extends GlobalConfig
{

    public function get($param)
    {
        return $this->getConfig('marketplace/inventory_setting/' . $param);
    }
}