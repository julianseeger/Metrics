<?php

namespace Metrics\Core\Entity;

class User
{
    private $name;
    private $password;

    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }
}
