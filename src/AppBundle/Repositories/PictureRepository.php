<?php

namespace AppBundle\Repositories;

use Doctrine\ORM\EntityRepository;

class PictureRepository extends EntityRepository
{
    public function fetchAlbumPicturesQuery($id)
    {
        return $this->createQueryBuilder('p')
            ->where('p.album_id = :album')->setParameter('album', $id)
            ->orderBy('p.id', 'desc');
    }
}
