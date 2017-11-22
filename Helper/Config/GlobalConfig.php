<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 9/8/17
 * Time: 4:14 PM
 */

namespace AWstreams\Marketplace\Helper\Config;


use AWstreams\Marketplace\Helper\AbstractHelper;

abstract class GlobalConfig extends AbstractHelper
{
    /**
     * Call method will handle all the fun
     * to get any config in general config call it with
     * getAdminEmail will get admin_email config  and so n.
     * @param $method
     * @param $params
     * @return string
     */
    public function __call($method, $params)
    {
        if ( substr( $method, 0, 3 ) === "get" )
        {
            $method = substr( $method, 3 );
            $pieces = preg_split('/(?=[A-Z])/',$method);
            unset($pieces[0]);
            $filtered = array_map('strtolower', $pieces);
            $column = implode('_', $filtered);
            return $this->get($column);
        }
        return null;

    }
    abstract public function get($param);

}