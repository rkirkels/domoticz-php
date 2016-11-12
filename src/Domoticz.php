<?php
/**
 * Base class
 *
 * @package rutgerkirkels\domoticz-php
 * @author Rutger Kirkels <rutger@kirkels.nl>
 * @since 1.0.0
 * @use rutgerkirkels\domoticz_php\Connector
 * @use rutgerkirkels\domoticz_php\Devices\NestThermostat
 */
namespace rutgerkirkels\domoticz_php;

use rutgerkirkels\domoticz_php\Connector;
use rutgerkirkels\domoticz_php\Devices\NestThermostat;
use rutgerkirkels\domoticz_php\Helpers\Timestamp;

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

        $connector = Connector::getInstance($this->hostname, self::$username, self::$password);
        $connector->setUserAgent('Domoticz PHP v' . self::$version['major'] . '.' . self::$version['minor'] . ' (' . php_uname('s') . '-' . php_uname('r') . '; PHP-' . PHP_VERSION . '; ' . PHP_SAPI . ') ');
    }

    public function getLightsAndSwitches() {
        $connector = Connector::getInstance();
        $connector->setUrlVars([
           'type' => 'command',
            'param' => 'getlightswitches'
        ]);

        $connector->execute();
        $response = $connector->getResponse();

        if ($response->getData()->result > 0) {
            $actors = [];
            foreach ($response->getData()->result as $actor) {
                $newActor = new Actor($actor->idx);
                $actors[] = $newActor;
            }
            return $actors;
        }
    }

    public function getTemperatureDevices() {
        $connector = Connector::getInstance();
        $connector->setUrlVars([
            'type' => 'devices',
            'filter' => 'temp',
            'order' => 'Name'
        ]);

        $connector->execute();
        $response = $connector->getResponse();

        $sensors = [];

        foreach ($response->getData()->result as $deviceData) {
            $sensor = new Sensor($deviceData->idx);
            $sensors[] = $sensor;
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

    public function getSwitch($idx) {
        $switch = new Actor($idx);
        $switch->setIdx($idx);
        return $switch;
    }

    public function getSunrise() {
        $connector = Connector::getInstance();

        $connector->setUrlVars([
            'type' => 'command',
            'param' => 'getSunRiseSet'
        ]);

        $connector->execute();

        $response = $connector->getResponse()->getData()->Sunset;

        return Timestamp::toObject($response);
    }

    public function getSunset() {
        $connector = Connector::getInstance();

        $connector->setUrlVars([
            'type' => 'command',
            'param' => 'getSunRiseSet'
        ]);

        $connector->execute();

        $response = $connector->getResponse()->getData()->Sunset;

        return Timestamp::toObject($response);
    }
}