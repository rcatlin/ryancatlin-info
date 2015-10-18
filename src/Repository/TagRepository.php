<?php

namespace RCatlin\Blog\Repository;

use Doctrine\ORM\EntityRepository;
use RCatlin\Blog\Entity;

class TagRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function findAllNames()
    {
        return $this->createQueryBuilder('t')
            ->select(
                ['t.name']
            )
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param string $name
     *
     * @return Entity\Tag|null
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByName($name)
    {
        $qb = $this->createQueryBuilder('t');

        $eq = $qb->expr()->eq(
            't.name',
            sprintf(
                "'%s'",
                $name
            )
        );

        return $qb->where($eq)
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
