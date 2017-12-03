<?php
namespace AWstreams\Marketplace\Api\Data;


interface ContactInerface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID           = 'id';
    const NAME         = 'name';
    const EMAIL        = 'email';
    const SUBJECT      = 'subject' ;
    const MESSAGE      = 'message';
    const CUSTOMER_ID  = 'customer_id';


    //id
    public function getId();
    public function setId($id);

    //name
    public function getName();
    public function setName($name);

    //email
    public function getEmail();
    public function setEmail($email);

    //subject
    public function getSubject();
    public function setSubject($subject);

    //message
    public function getMessage();
    public function setMessage($message);

    //shop id
    public function getCustomerId();
    public function setCustomerId($customer_id);



}