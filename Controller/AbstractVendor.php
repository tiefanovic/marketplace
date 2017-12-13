<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 12/13/17
 * Time: 5:01 PM
 */

namespace AWstreams\Marketplace\Controller;


use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\ResponseInterface;

class AbstractVendor extends AbstractAccount

{
    /**
     * Dispatch request
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        // TODO: Implement execute() method.
    }
}