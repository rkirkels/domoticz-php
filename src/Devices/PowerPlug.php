<?php

namespace rutgerkirkels\domoticz_php\Devices;

use rutgerkirkels\domoticz_php\Device;

class PowerPlug extends Device
{
    private $switchIdx = null;
    private $powerIdx = null;
    private $usageIdx = null;
    private $deviceData = null;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param null $switchIdx
     */
    public function setSwitchIdx($switchIdx)
    {
        $this->switchIdx = $switchIdx;
    }

    /**
     * @param null $powerIdx
     */
    public function setPowerIdx($powerIdx)
    {
        $this->powerIdx = $powerIdx;
    }

    /**
     * @param null $usageIdx
     */
    public function setUsageIdx($usageIdx)
    {
        $this->usageIdx = $usageIdx;
    }

    public function hasPowerData() {
        if (!empty($this->powerIdx)) {
            return true;
        }
        return false;
    }

    public function hasUsageData() {
        if (!empty($this->usageIdx)) {
            return true;
        }
        return false;
    }

    public function getPower() {
        if (empty($this->deviceData)) {
            return $this->getDeviceData($this->powerIdx)->Data;
        }
        return false;
    }

    public function getUsage() {
        if (empty($this->deviceData)) {
            return $this->getDeviceData($this->usageIdx)->Data;
        }
        return false;
    }

    public function getStatus() {
        if (empty($this->deviceData)) {
            return $this->getDeviceData($this->switchIdx)->Data;
        }
    }
}