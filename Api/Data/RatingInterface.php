<?php
namespace AWstreams\Marketplace\Api\Data;


interface RatingInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID           = 'id';
    const PRICE        = 'price';
    const VALUE        = 'value';
    const QUALITY      = 'quality';
    const NAME         = 'name';
    const SUMMARY      = 'summary';
    const REVIEW       = 'review' ;
    const SHOP_ID      = 'shop_id';


    //id
    public function getId();
    public function setId($id);

    //price
    public function getPrice();
    public function setPrice($price);

    //value
    public function getValue();
    public function setValue($vaule);

    //quality
    public function getQuality();
    public function setQuality($quality);

    //name
    public function getName();
    public function setName($name);

    //summary
    public function getSummary();
    public function setSummary($summary);

    //review
    public function getReview();
    public function setReview($review);

    //shop id
    public function getShopId();
    public function setShopId($shop_id);



}