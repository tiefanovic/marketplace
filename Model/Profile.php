<?php
namespace AWstreams\Marketplace\Model;

use AWstreams\Marketplace\Api\Data\ProfileInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Profile  extends \Magento\Framework\Model\AbstractModel implements ProfileInterface, IdentityInterface
{
    const CACHE_TAG = 'shop_information';
    protected $_cacheTag = 'shop_information';

    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\ResourceModel\Profile');
    }
    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


    //id
    public function getId(){
        return $this->getData(self::SHOP_ID);
    }
    public function setId($id){
        return $this->setData(self::SHOP_ID, $id);
    }

    //customer id
    public function getCustomerID(){
        return $this->getData(self::CUSTOMER_ID);

    }
    public function setCustomerID($cid){
        return $this->setData(self::CUSTOMER_ID, $cid);

    }


    //facebook
    public function getFacebookId(){
        return $this->getData(self::FACEBOOK_ID);

    }
    public function setFacebookId($fid){
        return $this->setData(self::FACEBOOK_ID, $fid);

    }


    //twitter id
    public function getTwitterId(){
        return $this->getData(self::TWITTER_ID);

    }
    public function setTwitterId($tid){
        return $this->setData(self::TWITTER_ID, $tid);
    }


    //instagram id
    public function getInstagramId(){
        return $this->getData(self::INSTAGRAM_ID);

    }
    public function setInstagramId($iid){
        return $this->setData(self::INSTAGRAM_ID, $iid);
    }


    //youtube id
    public function getYoutubeId(){
        return $this->getData(self::YOUTUBE_ID);

    }
    public function setYoutubeId($yid){
        return $this->setData(self::YOUTUBE_ID, $yid);
    }


    //contact number
    public function getContactNamber(){
        return $this->getData(self::CONTACT_NUMBER);
    }
    public function setContactNumber($cNumber){
        return $this->setData(self::CONTACT_NUMBER, $cNumber);
    }


    //Shop title
    public function getShopTitle(){
        return $this->getData(self::SHOP_TITLE);

    }
    public function setShopTitle($title){
        return $this->setData(self::SHOP_TITLE, $title);
    }


    //banner
    public function getBanner(){
        return $this->getData(self::SHOP_BANNER);

    }
    public function setBanner($banner){
        return $this->setData(self::SHOP_BANNER, $banner);
    }


    //logo
    public function getLogo(){
        return $this->getData(self::SHOP_LOGO);

    }
    public function setLogo($logo){
        return $this->setData(self::SHOP_LOGO, $logo);
    }



    //address
    public function getAddress(){
        return $this->getData(self::SHOP_ADDRESS);

    }
    public function setAddress($address){
        return $this->setData(self::SHOP_ADDRESS, $address);
    }


    //description
    public function getDescription(){
        return $this->getData(self::SHOP_ADDRESS);
    }
    public function setDescription($desc){
        return $this->setData(self::SHOP_DESCRIPTION, $desc);
    }


    //reutrn policy
    public function getReturnPolicy(){
        return $this->getData(self::RETURN_POLICY);
    }

    public function setReturnPolicy($return){
        return $this->setData(self::RETURN_POLICY, $return);
    }


    //shipping policy
    public function getShippingPolicy(){
        return $this->getData(self::SHIPPING_POLICY);
    }
    public function setShippingPolicy($shipping){
        return $this->setData(self::SHIPPING_POLICY, $shipping);
    }


    //tax
    public function getTax(){
        return $this->getData(self::TAX_NUMBER);
    }
    public function setTax($tax){
        return $this->setData(self::TAX_NUMBER, $tax);
    }



    //country
    public function getCountry(){
        return $this->getData(self::COUNTRY);
    }
    public function setCountry($country){
        return $this->setData(self::COUNTRY, $country);
    }

}