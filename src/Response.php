<?php
/**
 * Created by PhpStorm.
 * User: rutgerkirkels
 * Date: 31-10-16
 * Time: 22:42
 */

namespace rutgerkirkels\domoticz_php;


class Response
{
    private $info = null;
    private $data = null;

    /**
     * @return null
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @param null $info
     */
    public function setInfo($info)
    {
        $this->info = $info;
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }


}