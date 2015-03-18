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

    public function showAll(){
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
            'articles' => $article->getArticles(),
            'published' => "0265",
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
}
