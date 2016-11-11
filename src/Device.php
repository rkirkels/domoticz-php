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

    public function __construct($idx = null)
    {
        if (!empty($idx)) {
            $this->idx = $idx;
        }
        $this->connector = Connector::getInstance();
    }

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

    public function getDeviceData() {
        if (!empty($this->idx)) {
            $this->connector->setUrlVars([
                'type' => 'devices',
                'rid' => $this->idx
            ]);

            $this->connector->execute();
            return $this->connector->getResponse()->getData()->result[0];
        }
        return false;
    }

    public function getStatus() {
        if ($deviceData = $this->getDeviceData()) {
            return $deviceData->Status;
        }
        return false;
    }

    public function getLastUpdate() {
        if ($deviceData = $this->getDeviceData()) {
            $timestamp = new \DateTime();
            $timestamp->setTimestamp(strtotime($deviceData->LastUpdate));
            return $timestamp;
        }
        return false;
    }
}