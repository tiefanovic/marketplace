<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/12/17
 * Time: 5:10 PM
 */

namespace AWstreams\Marketplace\Api\Data;


use Magento\Framework\Api\CustomAttributesDataInterface;

/**
 * Interface ProductInterface
 * @package AWstreams\Marketplace\Api\Data
 */
interface VendorProductInterface extends CustomAttributesDataInterface

{
    /**
     * @return mixed
     */
    public function getVendorId();

    /**
     * @param $vendorId
     * @return mixed
     */
    public function setVendorId($vendorId);
}