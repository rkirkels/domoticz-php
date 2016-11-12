<?php


namespace rutgerkirkels\domoticz_php;


class Sensor extends Device
{

    public function __call($name, $arguments) {
        $deviceData = $this->getDeviceData();
        if (property_exists($deviceData,$name)) {
            return $deviceData->$name;
        }
        return false;
    }

    /**
     * @return null
     */
    public function getTemperature()
    {
        return $this->Temp();
    }

    public function getHumidity() {
        return $this->Humidity();
    }

    public function getUsage() {
        $deviceData = $this->getDeviceData();
        if (property_exists($deviceData, 'Humidity')) {
            return $deviceData->Humidity;
        }
        return false;
    }
}