<?php
namespace AWstreams\Marketplace\Model;



use AWstreams\Marketplace\Api\Data\RatingInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Rating  extends \Magento\Framework\Model\AbstractModel implements RatingInterface, IdentityInterface
{
    const CACHE_TAG = 'shop_rate';
    protected $_cacheTag = 'shop_rate';

    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\ResourceModel\Rating');
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
    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    //price
    public function getPrice()
    {
        return $this->getData(self::PRICE);
    }

    public function setPrice($price)
    {
        return $this->setData(self::PRICE, $price);
    }

    //value
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }

    //quality
    public function getQuality()
    {
        return $this->getData(self::QUALITY);
    }

    public function setQuality($quality)
    {
        return $this->setData(self::QUALITY, $quality);
    }


    //name
    public function getName(){
        return $this->getData(self::NAME);

    }
    public function setName($name){
        return $this->setData(self::NAME, $name);

    }
    //summary
    public function getSummary(){
        return $this->getData(self::SUMMARY);

    }
    public function setSummary($summary){
        return $this->setData(self::SUMMARY, $summary);

    }
    //review
    public function getReview(){
        return $this->getData(self::REVIEW);

    }
    public function setReview($review){
        return $this->setData(self::REVIEW, $review);

    }
    //Created_at
    public function getDate(){
        return $this->getData(self::CREATEDAT);

    }
    public function setDate($date){
        return $this->setData(self::REVIEW, $date);

    }
    //Created_at
    public function getApprove(){
        return $this->getData(self::APPROVE);

    }
    public function setApprove($approve){
        return $this->setData(self::APPROVE, $approve);

    }
    //shop id
    public function getShopId(){
        return $this->getData(self::SHOP_ID);

    }
    public function setShopId($shop_id){
        return $this->setData(self::SHOP_ID, $shop_id);

    }





}
