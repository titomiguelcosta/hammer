<?php

namespace App\Repository;

use App\Entity\OAuth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LinkedIn\AccessToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuth[]    findAll()
 * @method OAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OAuthRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OAuth::class);
    }

//    /**
//     * @return OAuth[] Returns an array of OAuth objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return OAuth|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLinkedInToken(): ?OAuth
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.service = :service')
            ->setParameter('service', OAuth::LINKEDIN)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param AccessToken $accessToken
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setLinkedInToken(AccessToken $accessToken)
    {
        $oauth = $this->getLinkedInToken() ?? new OAuth();
        $oauth->setService('LinkedIn');
        $oauth->setAccessToken($accessToken->getToken());
        $oauth->setRefreshToken('unknown');
        $oauth->setExpiresAt(new \DateTimeImmutable('@'.$accessToken->getExpiresAt()));

        $this->getEntityManager()->persist($oauth);
        $this->getEntityManager()->flush($oauth);
    }
}
