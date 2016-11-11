<?php

namespace rutgerkirkels\domoticz_php\Devices;

use rutgerkirkels\domoticz_php\Connector;
use rutgerkirkels\domoticz_php\Device;
use rutgerkirkels\domoticz_php\Domoticz;

class NestThermostat extends Device
{

    private $sensorIdx = null;
    private $heatingIdx = null;
    private $awayIdx = null;
    private $setpointIdx = null;

    public function __construct($sensorIdx = null, $heatingIdx = null, $awayIdx = null, $setpointIdx = null)
    {

        if (!empty($sensorIdx)) {
        $this->setSensorIdx($sensorIdx);
        }

        if (!empty($heatingIdx)) {
            $this->setHeatingIdx($heatingIdx);
        }

        if (!empty($awayIdx)) {
            $this->setAwayIdx($awayIdx);
        }

        if (!empty($setpointIdx)) {
            $this->setSetpointIdx($setpointIdx);
        }

    }

    /**
     * @return null
     */
    public function getSensorIdx()
    {
        return $this->sensorIdx;
    }

    /**
     * @param null $sensorIdx
     */
    public function setSensorIdx($sensorIdx)
    {
        $this->sensorIdx = $sensorIdx;
    }

    /**
     * @return null
     */
    public function getHeatingIdx()
    {
        return $this->heatingIdx;
    }

    /**
     * @param null $heatingIdx
     */
    public function setHeatingIdx($heatingIdx)
    {
        $this->heatingIdx = $heatingIdx;
    }

    /**
     * @return null
     */
    public function getAwayIdx()
    {
        return $this->awayIdx;
    }

    /**
     * @param null $awayIdx
     */
    public function setAwayIdx($awayIdx)
    {
        $this->awayIdx = $awayIdx;
    }

    /**
     * @return null
     */
    public function getSetpointIdx()
    {
        return $this->setpointIdx;
    }

    /**
     * @param null $setpointIdx
     */
    public function setSetpointIdx($setpointIdx)
    {
        $this->setpointIdx = $setpointIdx;
    }

    public function isHeatingOn() {
        $connector = Connector::getInstance();
        if (empty($this->heatingIdx)) {
            return false;
        }

        $connector->setUrlVars([
            'type' => 'devices',
            'rid' => $this->heatingIdx
        ]);

        $connector->execute();
        $response = $connector->getResponse();

        try {
            if ($response->getData()->result[0]->HardwareTypeVal !== Domoticz::NEST_HARDWARE_VALUE) {
                throw new \ErrorException('IDX ' . $this->heatingIdx . ' is not a Nest Thermostat');
            }

            if ($response->getData()->result[0]->Status === 'On') {
                return true;
            }
        } catch (\Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING) ;
        }

        return false;
    }

    public function isAway() {
        if (empty($this->awayIdx)) {
            return false;
        }

        $this->connector->setUrlVars([
            'type' => 'devices',
            'rid' => $this->awayIdx
        ]);

        $this->connector->execute();

        $response = $this->connector->getResponse();

        try {
            if ($response->getData()->result[0]->HardwareTypeVal !== Domoticz::NEST_HARDWARE_VALUE) {
                throw new \ErrorException('IDX ' . $this->awayIdx . ' is not a Nest Thermostat');
            }

            if ($response->getData()->result[0]->Status === 'On') {
                return true;
            }

        } catch (\Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING) ;
        }
        return false;
    }
}