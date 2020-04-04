<?php

namespace App\Repository;

use App\Entity\OAuth;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LinkedIn\AccessToken;

/**
 * @method OAuth|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuth|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuth[]    findAll()
 * @method OAuth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OAuthRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OAuth::class);
    }

    /**
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
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function setLinkedInToken(AccessToken $accessToken)
    {
        $oauth = $this->getLinkedInToken() ?? new OAuth();
        $oauth->setService('LinkedIn');
        $oauth->setAccessToken($accessToken->getToken());
        $oauth->setRefreshToken('unknown');
        $oauth->setExpiresAt(new \DateTimeImmutable('@' . $accessToken->getExpiresAt()));

        $this->getEntityManager()->persist($oauth);
        $this->getEntityManager()->flush();
    }
}
