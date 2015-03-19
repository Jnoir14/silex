<?php

namespace TestEmbauche\Repository;

use Doctrine\DBAL\Connection;

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

    public function getAll(){
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('a.*')
            ->from('article', 'a');
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
            $this->db->update('article', $articleData, array('article_id' => $article->getId()));

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
}
