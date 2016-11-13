<?php


namespace rutgerkirkels\domoticz_php;


class Sensor extends Device
{



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