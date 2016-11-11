<?php


namespace rutgerkirkels\domoticz_php;

use rutgerkirkels\domoticz_php\Connector;

class Device extends Domoticz
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

    protected function errorHandler($message, $level = E_USER_NOTICE) {
        $trace = @next(debug_backtrace());
        trigger_error($message . ' (Called in ' . $trace['file'] . ' on line ' . $trace['line'] . ')', $level);
    }
}