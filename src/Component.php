<?php


namespace rutgerkirkels\domoticz_php;


class Component
{
    protected $idx = null;
    protected $name = null;

    /**
     * @return null
     */
    public function getIdx()
    {
        return $this->idx;
    }

    /**
     * @param null $idx
     */
    public function setIdx($idx)
    {
        $this->idx = $idx;
    }

    /**
     * @return null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}