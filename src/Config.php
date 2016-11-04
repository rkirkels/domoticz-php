<?php

namespace rutgerkirkels\domoticz_php;
use rutgerkirkels\domoticz_php\Devices;

class Config
{
    private $appliances = [];

    public function __construct($configData)
    {
        $this->data = $configData;
    }

    public function loadAppliances() {
        $appliances = [];
        foreach ($this->data['appliances'] as $appliance) {
            $deviceClass = __NAMESPACE__ . '\Devices\\' . $appliance['deviceType'];
            $appliances[] = new $deviceClass;

        }
var_dump($appliances);

    }
}