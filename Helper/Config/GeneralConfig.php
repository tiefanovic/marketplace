<?php
/**
 * Created by PhpStorm.
 * User: awstreams
 * Date: 9/8/17
 * Time: 11:12 AM
 */

namespace AWstreams\Marketplace\Helper\Config;


class GeneralConfig extends GlobalConfig
{

    /**
     * @param $param string parameter
     * @return string will return value of parameter
     */
    public function get($param)
    {
        return $this->getConfig('marketplace/general/' . $param);
    }


}