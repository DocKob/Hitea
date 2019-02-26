<?php

namespace App\Entity;


class CustomerSearch
{

    private $name;

    public function __construct()
    {
        $this->name = '';
    }

    public function getName(): String
    {
        return $this->name;
    }

    public function setName(String $name): void
    {
        $this->name = $name;
    }
}
