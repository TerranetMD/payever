<?php

namespace AppBundle\Service;

use AppBundle\Repositories\AlbumRepository;
use AppBundle\Repositories\PictureRepository;
use AppBundle\Serializer\PaginatorSerializer;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Paginator;
use Symfony\Component\Serializer\Serializer;

class Gallery
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var PaginatorSerializer
     */
    private $paginatorSerializer;

    public function __construct(
        ObjectManager $entityManager,
        Serializer $serializer,
        Paginator $paginator,
        PaginatorSerializer $paginatorSerializer
    )
    {
        $this->em = $entityManager;
        $this->serializer = $serializer;
        $this->paginator = $paginator;
        $this->paginatorSerializer = $paginatorSerializer;
    }

    /**
     * Fetch albums
     *
     * @return array
     */
    public function albums()
    {
        /** @var $repo AlbumRepository */
        $repo = $this->em->getRepository("AppBundle:Album");

        return $this->serializer->normalize($repo->all(), 'json', ['groups' => ['short']]);
    }

    /**
     * Fetch paginated collection of album pictures
     *
     * @param $albumId
     * @param int $page
     * @param int $perPage
     * @return array
     */
    public function pictures($albumId, $page = 1, $perPage = 12)
    {
        /** @var $repo PictureRepository */
        $repo = $this->em->getRepository("AppBundle:Picture");

        $query = $repo->fetchAlbumPicturesQuery($albumId);

        /** @var $slider SlidingPagination */
        $slider = $this->paginator->paginate($query, $page, $perPage);

        $pictures = $this->serializer->normalize($slider->getItems(), 'json', ['groups' => ['short']]);

        $slider = $this->paginatorSerializer->normalize($slider);

        return [$pictures, $slider];
    }

    public function picture($id)
    {
        $repo = $this->em->getRepository("AppBundle:Picture");

        $picture = $repo->findOneBy(['id' => $id]);

        return $this->serializer->normalize($picture, 'json', ['groups' => ['full']]);
    }
}
