<?php
namespace AWstreams\Marketplace\Api\Data;


interface ProfileInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const SHOP_ID           = 'shop_id';
    const CUSTOMER_ID       = 'customer_id';
    const FACEBOOK_ID       = 'facebook_id';
    const TWITTER_ID        = 'twitter_id';
    const YOUTUBE_ID        = 'youtube_id';
    const INSTAGRAM_ID      = 'instagram_id';
    const CONTACT_NUMBER    = 'contact_number';
    const TAX_NUMBER        = 'tax_number';
    const SHOP_TITLE        = 'shop_title';
    const SHOP_BANNER       = 'shop_banner';
    const SHOP_LOGO         = 'shop_logo';
    const SHOP_DESCRIPTION  = 'shop_description';
    const RETURN_POLICY     = 'return_policy';
    const SHIPPING_POLICY   = 'shipping_policy';
    const COUNTRY           = 'country';
    const SHOP_ADDRESS      = 'shop_address';


    //id
    public function getId();
    public function setId($id);

    //customer id
    public function getCustomerID();
    public function setCustomerID($cid);


    //facebook
    public function getFacebookId();
    public function setFacebookId($fid);


    //twitter id
    public function getTwitterId();
    public function setTwitterId($tid);


    //instagram id
    public function getInstagramId();
    public function setInstagramId($iid);


    //youtube id
    public function getYoutubeId();
    public function setYoutubeId($yid);


    //contact number
    public function getContactNamber();
    public function setContactNumber($cNumber);


    //Shop title
    public function getShopTitle();
    public function setShopTitle($title);


    //banner
    public function getBanner();
    public function setBanner($banner);


    //logo
    public function getLogo();
    public function setLogo($logo);



    //address
    public function getAddress();
    public function setAddress($address);


    //description
    public function getDescription();
    public function setDescription($desc);


    //reutrn policy
    public function getReturnPolicy();
    public function setReturnPolicy($return);


    //shipping policy
    public function getShippingPolicy();
    public function setShippingPolicy($shipping);


    //tax
    public function getTax();
    public function setTax($tax);



    //country
    public function getCountry();
    public function setCountry($country);



}