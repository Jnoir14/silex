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
     * article.
     *
     * @var string
     */
    protected $article;

    /**
     * Published.
     *
     * @var boolean
     */
    protected $published;

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

    public function getArticle()
    {
        return $this->article;
    }

    public function setArticle($article)
    {
        $this->article = $article;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setPublished($published)
    {
        $this->published = $published;
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
