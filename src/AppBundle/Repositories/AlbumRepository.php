<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class AlbumRepository extends EntityRepository
{
    /**
     * @param int $page
     * @return \AppBundle\Entity\Album[]
     */
    public function all()
    {
        $query = $this
            ->createQueryBuilder('a')
            ->orderBy('a.created_at', 'desc')
            ->getQuery();

        return $query->execute();
    }
}