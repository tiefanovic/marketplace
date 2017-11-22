<?php
/**
 * SellerReviewConfig
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Helper\Config;


class SellerReviewConfig extends GlobalConfig
{

    public function get($param)
    {
        return $this->getConfig('marketplace/marketplace_seller_review_settings/' . $param);
    }
}