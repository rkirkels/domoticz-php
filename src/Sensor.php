<?php


namespace rutgerkirkels\domoticz_php;


class Sensor extends Device
{
    public function __construct($data)
    {
        $this->init($data);
    }

    /**
     * @return null
     */
    public function getTemperature()
    {
        if (property_exists($this->deviceData, 'Temp')) {
            return $this->deviceData->Temp;
        }
        return false;
    }

    public function getHumidity() {
        if (property_exists($this->deviceData, 'Humidity')) {
            return $this->deviceData->Humidity;
        }
        return false;
    }
}