<?php
/**
 * Created by PhpStorm.
 * User: joel
 * Date: 20/03/15
 * Time: 14:07
 */

namespace TestEmbauche\Repository;
use Doctrine\DBAL\Connection;


class WorkRepository {
    protected  $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function getByid($id){
        $queryBuilder = $this->db->createQueryBuilder('a');
        $queryBuilder
            ->select('a.*')
            ->from('works', 'a')
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
            ->from('works', 'a');
        $statement = $queryBuilder->execute();
        $articleData = $statement->fetchAll();
        return $articleData;
    }

    public function save($works)
    {
        $worksData = array(
            'title'   =>  $works->getTitle(),
            'content' =>  $works->getContent(),
            'image_path'=>  $works->getImage(),
        );

        if ($works->getId()) {
            $this->db->update('works', $worksData, array('id' => $works->getId()));
        } else {
            $time= new \DateTime("now");
            $worksData['created_at'] = $time->format('ymd');

            $this->db->insert('works', $worksData);

            $id = $this->db->lastInsertId();
            $works->setId($id);

            $newFile = $this->uploadDir($works, $time);
            if ($newFile) {
                $newData = array('image_path' => $works->getImage());
                $this->db->update('works', $newData, array('id' => $id));
            }
        }
    }

    protected function uploadDir($works, $time) {
        $file = $works->getFile();
        if ($file) {
            $newFilename = $time->format('His') . '.' . $file->guessExtension();
            $file->move(TESTEMBAUCHE_ROOT.'/img/works/', $newFilename);
            $works->setFile(null);
            $works->setImage($newFilename);
            return TRUE;
        }
        return FALSE;
    }



    public function delete($id)
    {
        return $this->db->delete('article', array('id' => $id));
    }
} 