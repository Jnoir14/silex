<?php

namespace TestEmbauche\Repository;

use Doctrine\DBAL\Connection;
use Symfony\Component\Validator\Constraints\DateTime;
use TestEmbauche\Model\Article;

class ArticleRepository
{
    protected  $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getByid($id){
        $queryBuilder = $this->db->createQueryBuilder('a');
        $queryBuilder
            ->select('a.*')
            ->from('article', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id);
        $statement = $queryBuilder->execute();
        $articleData = $statement->fetch();
        return $articleData;
    }

    public function getByCategory($category){
        $queryBuilder = $this->db->createQueryBuilder('a');
        $queryBuilder
            ->select('a.*')
            ->from('article', 'a')
            ->where('a.category_id = :category')
            ->setParameter('category', $category);
        $statement = $queryBuilder->execute();
        $articlesData = $statement->fetchAll();

        $articles = array();
        foreach ($articlesData as $articleData) {
            $articleId = $articleData['id'];
            $articles[$articleId] = $this->buildArticle($articleData);
        }

        return $articles;
    }

    public function getAll(){
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('article', 'a')
            ->orderBy('a.id', 'DESC');
        $statement = $queryBuilder->execute();
        $articleData = $statement->fetchAll();

        return $articleData;
    }

    public function save($article)
    {

        $articleData = array(
            'title'   =>  $article->getTitle(),
            'content' =>  $article->getContent(),
            'category_id'=>  $article->getCategory(),
        );

        if ($article->getId()) {
            $time= new \DateTime("now");
            $articleData['created_at'] = $time->format('ymd');
            $this->db->update('article', $articleData, array('id' => $article->getId()));

        } else {
            $time= new \DateTime("now");
            $articleData['created_at'] = $time->format('ymd');
            $this->db->insert('article', $articleData);

            $id = $this->db->lastInsertId();
            $article->setId($id);
        }
    }

    public function delete($id)
    {
        return $this->db->delete('article', array('id' => $id));
    }

    public function buildArticle($articleData){
        $article = new Article();
        $article->setId($articleData['id']);
        $article->setTitle($articleData['title']);
        $article->setContent($articleData['content']);
        $article->setCategory($articleData['category_id']);
        return $article;
    }
}
