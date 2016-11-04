<?php

namespace rutgerkirkels\domoticz_php;

use rutgerkirkels\domoticz_php\Connector;
use rutgerkirkels\domoticz_php\Devices\NestThermostat;

class Domoticz
{
    private $hostname = null;
    private static $username = null;
    private static $password = null;
    private static $version = [
        'major'     => '1',
        'minor'     => '0',
        'revision'  => '0',
        'patch'     => '0',
        'stability' => '',
        'number'    => '',
    ];
    private $connector = null;
    private $Config = null;
    private static $getSingleton;
    const NEST_HARDWARE_VALUE = 52;
    public static function singleton() {
        if (null === self::$getSingleton) {
            self::$getSingleton = new Domoticz();
        }
    }

    public function __construct($hostname = null, $username = null, $password = null)
    {
        $this->hostname = $hostname;

        if (!empty($username)) {
            self::$username = $username;
        }

        if (!empty($password)) {
            self::$password = $password;
        }

        $this->connector = Connector::getInstance($this->hostname); //new Connector($this->hostname);
        $this->connector->setUserAgent('Domoticz PHP v' . self::$version['major'] . '.' . self::$version['minor'] . ' (' . php_uname('s') . '-' . php_uname('r') . '; PHP-' . PHP_VERSION . '; ' . PHP_SAPI . ') ');
    }

    public function getLightsAndSwitches() {
        $this->connector->setUrlVars([
           'type' => 'command',
            'param' => 'getlightswitches'
        ]);

        $response = $this->send();

        if ($response->getData()->result > 0) {
            $actors = [];
            foreach ($response->getData()->result as $actor) {
                $newActor = new Actor();
                $newActor->setIdx(intval($actor->idx));
                $newActor->setName($actor->Name);
                $actors[] = $newActor;
            }
            return $actors;
        }
    }

    public function getTemperatureDevices() {
        $this->connector->setUrlVars([
            'type' => 'devices',
            'filter' => 'temp',
            'order' => 'Name'
        ]);

        $response = $this->send();

        $sensors = [];
        foreach ($response->getData()->result as $deviceData) {
            $sensors[] = new Sensor($deviceData);
        }
        return $sensors;
    }

    private function send() {
        if (!empty(self::$username) && !empty(self::$password)) {
            $this->connector->setUsername(self::$username);
            $this->connector->setPassword(self::$password);
        }
        $this->connector->execute();
        return $this->connector->getResponse();
    }

    public function getNestThermostat($sensorIdx = null, $heatingIdx = null, $awayIdx = null, $setpointIdx = null) {
        $thermostat = new NestThermostat($sensorIdx, $heatingIdx, $awayIdx, $setpointIdx);
        return $thermostat;
    }

    public static function getVersion() {
        $versionString = self::$version['major'] . '.' . self::$version['minor'] . '.' . self::$version['revision'];
        return $versionString;
    }

    public function loadConfig($file) {
        $data = \Spyc::YAMLLoad('config.yaml');
        $this->Config = new Config($data);
        return true;
    }

    public function getAppliances() {
        return $this->Config->loadAppliances();
    }
}