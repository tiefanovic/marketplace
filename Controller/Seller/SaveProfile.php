<?php
namespace AWstreams\Marketplace\Controller\Seller;


use AWstreams\Marketplace\Model\ResourceModel\Profile\Collection;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Image\AdapterFactory;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\Filesystem;
class SaveProfile extends Action
{

    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    protected $customerSession;
    protected $_customerRepositoryInterface;
    protected $_resultFactory;
    protected $_resources;
    protected $currentCustomer;
    protected $profileCollection;
    protected $profileCollection2;
    protected $adapterFactory;
    protected $uploader;
    protected $filesystem ;

    public function __construct(Context $context,
                                CustomerFactory $customerFactory,
                                Session $customerSession,
                                Collection $profileCollection,
                                AdapterFactory $adapterFactory,
                                UploaderFactory $uploaderFactory,
                                Filesystem $filesystem,
                                CustomerRepositoryInterface $customerRepositoryInterface)

    {

        $this->customerFactory  = $customerFactory;
        $this->_resultFactory = $context->getResultFactory();
        $this->customerSession = $customerSession;
        $this->profileCollection= $profileCollection;
        $this->profileCollection2= $profileCollection;
        $this->adapterFactory =$adapterFactory;
        $this->uploader = $uploaderFactory;
        $this->filesystem= $filesystem;
        $this->currentCustomer =$this->customerSession->getCustomer();
        $this->_customerRepositoryInterface = $customerRepositoryInterface;
        parent::__construct($context);
    }

    public function execute()
    {



        $post = $this->getRequest()->getPostValue();

        if (!$post)
            return $this->_redirect('*/*/');


        if (empty($post['shop_title']) ) {
            $this->messageManager->addErrorMessage('Please Enter Your Shop Title.');
            $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }

        $shops = $this->profileCollection2->addFieldToSelect('*')->getData();/*getData();*///addFieldToFilter('shop_title', $post['shop_title'])->getFirstItem()->getData('shop_title');

        $customerId = $this->currentCustomer->getId();
        echo $customerId ."====";

        $shopId =$this->hasProfile($customerId);
        if($shopId != 0 )
            $model = $this->_objectManager->create('AWstreams\Marketplace\Model\Profile')->load($shopId);
        else
            $model = $this->_objectManager->create('AWstreams\Marketplace\Model\Profile');

        $check =false;
        foreach ($shops  as $shop)
            if($shop['shop_title'] == $post['shop_title'])
                $check =true;



        if(!empty($model->getShopTitle())) {
            if ($model->getShopTitle() != $post['shop_title']) {

                if ($check ) {
                    $this->messageManager->addErrorMessage('Your Shop Title is exists');
                    $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                    $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                    return $resultRedirect;
                }
            }
        }else{
            if ($check) {
                $this->messageManager->addErrorMessage('Your Shop Title is exists');
                $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }
        }


        //save image

        if (!empty($_FILES['shop_banner']['name'])) {
            $banner = $_FILES['shop_banner'];
            $file_name = $this->saveImage($banner);
            if($file_name != false){
                $model->setBanner($file_name);
            }else{
                $this->messageManager->addErrorMessage('Your Shop Banner image type must be jpg or jpeg or png.');
                $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }

        }

        if (!empty($_FILES['shop_logo']['name'])) {

            $logo =$_FILES['shop_logo'];
            $file_name = $this->saveImage($logo);
            if($file_name != false){
                $model->setLogo($file_name);
            }else{
                $this->messageManager->addErrorMessage('Your Shop Logo image type must be jpg or jpeg or png.');
                $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }

        }
        //check of tax number must be number
        if(!empty($post["tax_number"])){
            if(!is_numeric($post["tax_number"])){
                $this->messageManager->addErrorMessage('Your Tax Number must be Number.');
                $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
                $resultRedirect->setUrl($this->_redirect->getRefererUrl());
                return $resultRedirect;
            }

        }

        $model->setCustomerID($customerId);
        $model->setFacebookId($post['facebook_id']);
        $model->setTwitterId($post['twitter_id']);
        $model->setYoutubeId($post['youtube_id']);
        $model->setInstagramId($post['instagram_id']);
        $model->setContactNumber($post['contact_number']);
        $model->setShopTitle($post['shop_title']);
        $model->setDescription($post['shop_description']);
        $model->setAddress($post['shop_address']);
        $model->setReturnPolicy($post['return_policy']);
        $model->setShippingPolicy($post['shipping_policy']);
        $model->setTax($post['tax_number']);
        $model->setCountry($post['country']);

        $model->save();
        // Display the succes form validation message
        $this->messageManager->addSuccessMessage('Done !');

        // Redirect to your form page (or anywhere you want...)
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());

        return $resultRedirect;


    }

    private function hasProfile($customerId)
    {
        $profiles = $this->profileCollection->getData();
        foreach ($profiles as $profile){
            if ($profile['customer_id'] ==  $customerId)
                return $profile['shop_id'];
        }
        return 0;

    }

    private function saveImage($banner){
        $mediaPath = $this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath();
        $media = $mediaPath . 'shop/';

        $file_name = rand() ."_". $banner['name'];
        $file_size = $banner['size'];
        $file_tmp =$banner['tmp_name'];
        $file_type = $banner['type'];
        $types = ['jpeg','jpg','png','PNG','JPEG','JPG'];
        $file_type = str_replace("image/","",$file_type);
        if(!in_array($file_type,$types)){
            return false ;
        }

        if (move_uploaded_file($file_tmp, $media . $file_name))
            return $file_name;

    }
}


