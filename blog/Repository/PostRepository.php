<?php
namespace VZenix\Bundle\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping as ORM;
use VZenix\Bundle\BlogBundle\Entity\Post;

class PostRepository extends EntityRepository
{
    public function countBy(array $criteria = array())
    {
        $persister = $this->_em->getUnitOfWork()->getEntityPersister($this->_entityName);
        return $persister->count($criteria);
    }

    public function findByField($query, $limit, $offset): array
    {
        $result = $this->_em->getRepository(Post::class)->createQueryBuilder('o')
            ->andWhere('o.content LIKE :query')
            ->orderBy('o.created', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getResult();

        return $result;
    }

    public function countByField($query)
    {
        $result = $this->_em->getRepository(Post::class)->createQueryBuilder('o')
            ->select('count(o.id)')
            ->andWhere('o.content LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->getQuery()
            ->getSingleScalarResult();

        return $result;
    }
}