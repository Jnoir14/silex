<?php

namespace TestEmbauche\Model;


class Category
{
    /**
     * Comment id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Name.
     *
     * @var name
     */
    protected $name;



    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}