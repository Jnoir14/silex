<?php

namespace TestEmbauche\Model;


class Article
{
    /**
     * Comment id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Title.
     *
     * @var string
     */
    protected $title;

    /**
     * Content.
     *
     * @var string
     */
    protected $content;

    /**
     * Category.
     *
     * @var \TestEmbauche\Model\Category
     */
    protected $category;

    /**
     * When the comment entity was created.
     *
     * @var DateTime
     */
    protected $createdAt;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }


    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
