<?php

namespace rutgerkirkels\domoticz_php;


class Connector
{
    private $url = null;
    private $urlVars = [];

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function execute() {
        $url = $this->url;

        if (!empty($this->getVars)) {
            $getVars = array();
            foreach ($this->getVars as $key => $value) {
                $getVars[] = $key . '=' . rawurlencode($value);
            }
            $url .= '?' . implode('&',$getVars);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        return true;
    }

    public function setUrlVars(array $urlVars) {
        $this->urlVars = $urlVars;
    }
}