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
    }

    public function getLightsAndSwitches() {
        $this->connector->setUrlVars([
           'type' => 'command',
            'param' => 'getlightswitches'
        ]);

        if (!empty($this->username) && !empty($this->password)) {
            $this->connector->setUsername($this->username);
            $this->connector->setPassword($this->password);
        }
        $this->connector->execute();
    }

    /**
     * @return null
     */
    public function getHostname()
    {
        return $this->hostname;
    }

}