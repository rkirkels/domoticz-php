<?php
/**
 * Power Plug Device Class
 *
 * @package rutgerkirkels\domoticz_php
 * @author Rutger Kirkels <rutger@kirkels.nl>
 * @extends rutgerkirkels\domoticz_php\Device
 */
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
     * Sets the IDX of the switch in the powerplug
     * @param integer $switchIdx
     */
    public function setSwitchIdx($switchIdx)
    {
        $this->switchIdx = $switchIdx;
    }

    /**
     * Sets the IDX of the power sensor in the powerplug
     * @param integer $powerIdx
     */
    public function setPowerIdx($powerIdx)
    {
        $this->powerIdx = $powerIdx;
    }

    /**
     * @param integer $usageIdx
     */
    public function setUsageIdx($usageIdx)
    {
        $this->usageIdx = $usageIdx;
    }

    /**
     * Determines if the powerplug can provide power information
     * @return bool
     */
    public function hasPowerData() {
        if (!empty($this->powerIdx)) {
            return true;
        }
        return false;
    }

    /**
     * Determines if the powerplug can provide usage information
     * @return bool
     */
    public function hasUsageData() {
        if (!empty($this->usageIdx)) {
            return true;
        }
        return false;
    }

    /**
     * Gets the current power output data from the powerplug
     * @return string|bool
     */
    public function getPower() {
        if (empty($this->deviceData)) {
            return $this->getDeviceData($this->powerIdx)->Data;
        }
        return false;
    }

    /**
     * Gets the current usage from the powerplug
     * @return string|bool
     */
    public function getUsage() {
        if (empty($this->deviceData)) {
            return $this->getDeviceData($this->usageIdx)->Data;
        }
        return false;
    }

    /**
     * Gets the current switch state of the powerplug
     * @return mixed
     */
    public function getStatus() {
        if (empty($this->deviceData)) {
            return $this->getDeviceData($this->switchIdx)->Data;
        }
    }
}