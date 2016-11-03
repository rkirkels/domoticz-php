<?php

namespace rutgerkirkels\domoticz_php;

use rutgerkirkels\domoticz_php\Connector;

class Domoticz
{
    private $hostname = null;
    private $username = null;
    private $password = null;
    private $version = [
        'major'     => '1',
        'minor'     => '0',
        'revision'  => '0',
        'patch'     => '0',
        'stability' => '',
        'number'    => '',
    ];
    private $connector = null;
    public function __construct($hostname, $username = null, $password = null)
    {
        $this->hostname = $hostname;

        if (!empty($username)) {
            $this->username = $username;
        }

        if (!empty($password)) {
            $this->password = $password;
        }

        $this->connector = new Connector($this->hostname);
        $this->connector->setUserAgent('Domoticz PHP v' . $this->version['major'] . '.' . $this->version['minor'] . ' (' . php_uname('s') . '-' . php_uname('r') . '; PHP-' . PHP_VERSION . '; ' . PHP_SAPI . ') ');
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
        if (!empty($this->username) && !empty($this->password)) {
            $this->connector->setUsername($this->username);
            $this->connector->setPassword($this->password);
        }
        $this->connector->execute();
        return $this->connector->getResponse();
    }

}