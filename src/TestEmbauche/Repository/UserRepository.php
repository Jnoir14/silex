<?php

namespace TestEmbauche\Repository;

use Doctrine\DBAL\Connection;
use TestEmbauche\Model\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * User repository
 */
class UserRepository implements UserProviderInterface
{

    protected $db;
    protected $encoder;

    public function __construct(Connection $db, $encoder)
    {
        $this->db = $db;
        $this->encoder = $encoder;
    }


    public function save($user)
    {
        $userData = array(
            'username' => $user->getUsername(),
            'mail' => $user->getMail(),
            'role' => $user->getRole(),
        );

        if (strlen($user->getPassword()) != 50) {
            $userData['salt'] = uniqid(mt_rand());
            $userData['password'] = $this->encoder->encodePassword($user->getPassword(), $userData['salt']);
        }

        if ($user->getId()) {
            $this->db->update('users', $userData, array('id' => $user->getId()));
        } else {
            $userData['created_at'] = time();
            $this->db->insert('users', $userData);
            $id = $this->db->lastInsertId();
            $user->setId($id);
        }
    }


    public function delete($id)
    {
        return $this->db->delete('users', array('id' => $id));
    }

    public function find($id)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->setMaxResults(1);
        $statement = $queryBuilder->execute();
        $userData = $statement->fetch();
        return $userData ? $this->buildUser($userData) : FALSE;
    }

    /*
     * Hériter de userprov
     */
    public function loadUserByUsername($username)
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->where('u.username = :username OR u.mail = :mail')
            ->setParameter('username', $username)
            ->setParameter('mail', $username)
            ->setMaxResults(1);
        $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();
        if (empty($usersData)) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $username));
        }

        $user = $this->buildUser($usersData[0]);
        return $user;
    }

    /*
     * Hériter de userprov
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        $id = $user->getId();
        $refreshedUser = $this->find($id);
        if (false === $refreshedUser) {
            throw new UsernameNotFoundException(sprintf('User with id %s not found', json_encode($id)));
        }

        return $refreshedUser;
    }

    /*
     * Hériter de userprov
     */
    public function supportsClass($class)
    {
        return 'TestEmbauche\Model\User' === $class;
    }

    /*
     * Retourne une entité user apartir des résultats
     */
    protected function buildUser($userData)
    {
        $user = new User();
        $user->setId($userData['id']);
        $user->setUsername($userData['username']);
        $user->setSalt($userData['salt']);
        $user->setPassword($userData['password']);
        $user->setMail($userData['mail']);
        $user->setRole($userData['role']);
        $createdAt = new \DateTime('@' . $userData['created_at']);
        $user->setCreatedAt($createdAt);
        return $user;
    }
}
