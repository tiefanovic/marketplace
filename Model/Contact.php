<?php
namespace AWstreams\Marketplace\Model;

use AWstreams\Marketplace\Api\Data\ContactInerface;
use Magento\Framework\DataObject\IdentityInterface;

class Contact  extends \Magento\Framework\Model\AbstractModel implements ContactInerface, IdentityInterface
{
    const CACHE_TAG = 'shop_contact';
    protected $_cacheTag = 'shop_contact';

    protected function _construct()
    {
        $this->_init('AWstreams\Marketplace\Model\ResourceModel\Contact');
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

    //name
    public function getName(){
        return $this->getData(self::NAME);

    }
    public function setName($name){
        return $this->setData(self::NAME, $name);

    }

    //email
    public function getEmail(){
        return $this->getData(self::EMAIL);

    }
    public function setEmail($email){
        return $this->setData(self::EMAIL, $email);
    }

    //subject
    public function getSubject(){
        return $this->getData(self::SUBJECT);

    }
    public function setSubject($subject){
        return $this->setData(self::SUBJECT, $subject);

    }

    //message
    public function getMessage(){
        return $this->getData(self::MESSAGE);

    }
    public function setMessage($message){
        return $this->setData(self::MESSAGE, $message);

    }

    //shop id
    public function getCustomerId(){
        return $this->getData(self::CUSTOMER_ID);

    }
    public function setCustomerId($customer_id){
        return $this->setData(self::CUSTOMER_ID, $customer_id);

    }



}