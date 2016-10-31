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

        $this->setUserAgent();
        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true);

        if (!empty($this->username) && !empty($this->password)) {
            $this->setAuthenticationHeader();
        }
        $data = curl_exec($this->connection);
        $info = curl_getinfo($this->connection);
        if ($info['http_code'] === 200 && json_decode($data)) {
            $this->response = new Response();
            $this->response->setInfo($info);
            $this->response->setData(json_decode($data));
            return true;
        }
        return false;
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
        curl_setopt($this->connection, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        return true;
    }

    public function setUserAgent($string) {
        curl_setopt($this->connection,CURLOPT_USERAGENT,$string);
        return true;
    }
    public function getResponse() {
        return $this->response;
    }
}