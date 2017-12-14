<?php
namespace AWstreams\Marketplace\Controller\Seller;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Customer\Model\Session;
use \Magento\Framework\App\ObjectManager;
use Magento\Catalog\Model\ResourceModel\Product\Collection AS Product;

class Cancel extends Action
{
    protected $orderManagement;
    protected $_resultFactory;
    protected $currentCustomer;
    protected $_session;
    protected  $productCollection ;


    public function __construct(Context $context,
                                Session $session,
                                Product $product ,
                                \Magento\Sales\Api\OrderManagementInterface $orderManagement
    ) {
        $this->orderManagement = $orderManagement;
        $this->_resultFactory = $context->getResultFactory();
        $this->productCollection = $product;
        $this->_session = $session;
        $this->currentCustomer = $this->_session->getCustomer();
        parent::__construct($context);
    }
    public function execute()
    {
        $parameter = $this->getRequest()->getParams();

        $orderId = $parameter['id'];


        $objectManager = ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);//loadByIncrementId(000000001);
        $orderItems = $order->getAllItems();
        $ids = $this->getProductCollection();


        foreach ($orderItems as $item) {
            if(in_array($item['product_id'],$ids)){
                $item->setQtyCanceled($item['qty_ordered']);
                $item->save();
            }
        }

        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;
    }


    public function getSpcificOrder($id){
        $objectManager = ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order')->load($id);
        return   $order;
    }

    public function getProductCollection(){

        $customer_id =$this->currentCustomer->getId();
        $vendor = $this->productCollection->getAllAttributeValues('vendor_id');

        $productIds = array() ;
        foreach ($vendor as $k =>$v){
            foreach ($v as $kk => $vv){
                if($vv == $customer_id)
                    array_push($productIds,$k);
            }
        }

        return   $productIds;
    }


}