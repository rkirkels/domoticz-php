<?php


namespace rutgerkirkels\domoticz_php;


class Device
{
    protected $idx = null;
    protected $name = null;
    protected $lastUpdate = null;
    protected $hardwareType = null;

    protected $deviceData = null;

    protected function init($deviceData) {
        $this->deviceData = $deviceData;

        if (property_exists($deviceData, 'idx')) {
            $this->idx = $deviceData->idx;
        }

        if (property_exists($deviceData, 'Name')) {
            $this->name = $deviceData->Name;
        }
    }
    /**
     * @return null
     */
    public function getLastUpdate()
    {
        if (property_exists($this->deviceData, 'LastUpdate')) {
            $timestamp = new \DateTime();
            $timestamp->setTimestamp(strtotime($this->deviceData->LastUpdate));
            return $timestamp;
        }
    }
    /**
     * @return null
     */
    public function getIdx()
    {
        return $this->idx;
    }

    /**
     * @return null
     */
    public function getHardwareType()
    {
        return $this->hardwareType;
    }

    /**
     * @param null $hardwareType
     */
    public function setHardwareType($hardwareType)
    {
        $this->hardwareType = $hardwareType;
    }

    /**
     * @param null $idx
     */
    public function setIdx($idx)
    {
        $this->idx = $idx;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}