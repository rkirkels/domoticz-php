<?php

namespace rutgerkirkels\domoticz_php;


class Connector
{
    private $url = null;
    private $urlVars = [];
    private $username = null;
    private $password = null;
    private $connection = null;

    public function __construct($url)
    {
        $this->url = $url . '/json.htm';
    }

    public function execute() {
        $url = $this->url;

        if (!empty($this->urlVars)) {
            $getVars = array();
            foreach ($this->urlVars as $key => $value) {
                $urlVars[] = $key . '=' . rawurlencode($value);
            }
            $url .= '?' . implode('&',$urlVars);
        }

        $this->connection = curl_init($url);
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true);

        if (!empty($this->username) && !empty($this->password)) {
            $this->setAuthenticationHeader();
        }
        $response = curl_exec($this->connection);
        $info = curl_getinfo($this->connection);
var_dump($response);
        return true;
    }

    public function setUrlVars(array $urlVars) {
        $this->urlVars = $urlVars;
    }

    /**
     * @param null $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param null $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    private function setAuthenticationHeader() {
//        echo $authorizationHeader = base64_encode($this->username . ':' . $this->password);
        curl_setopt($this->connection, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        return true;
    }
}