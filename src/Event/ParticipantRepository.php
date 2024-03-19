<?php

declare(strict_types=1);

namespace Teammates\Event;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method null|Participant find($id, $lockMode = null, $lockVersion = null)
 * @method null|Participant findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participant::class);
    }

    public function save(Participant $participant): void
    {
        $this->getEntityManager()->persist($participant);
        $this->getEntityManager()->flush();
    }
}
