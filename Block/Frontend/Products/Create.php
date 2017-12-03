<?php
/**
 * Create
 *
 * @copyright Copyright © 2017 AWstreams. All rights reserved.
 * @author    ahmed.atef@awstreams.com
 */

namespace AWstreams\Marketplace\Block\Frontend\Products;


use Magento\Framework\View\Element\Template;

class Create extends Template
{

   public function getPostActionUrl(){
       return $this->getUrl('marketplace/products/save');
   }
   public function getAjaxUrl(){
       return $this->getUrl('marketplace/products/search');
   }
}