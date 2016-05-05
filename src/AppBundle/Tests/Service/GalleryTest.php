<?php

namespace AppBundle\Tests\Service;

use AppBundle\Entity\Album;
use AppBundle\Repositories\AlbumRepository;
use AppBundle\Service\Gallery;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class GalleryTest extends KernelTestCase
{
    /**
     * @var Container
     */
    protected $container;

    public function setUp()
    {
        parent::setUp();

        static::bootKernel();

        $this->container = static::$kernel->getContainer();
    }

    /** @test */
    public function it_fetches_the_albums()
    {
        // Now, mock the repository so it returns the mock of the Album
        $albumRepository = $this->mockAlbumRepository();
        $albumRepository->expects($this->once())
            ->method('all')
            ->willReturn($this->albums());

        // Last, mock the EntityManager to return the mock of the repository
        $entityManager = $this->mockEntityManager();

        $entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($albumRepository);

        /**
         * @var $gallery Gallery
         */
        $gallery = $this->container->get('gallery');

        $albums = $gallery->albums();

        $this->assertCount(2, $albums);
    }

    protected function albums()
    {
        $album = new Album();
        $album->setName('Album 1');
        $album->setCreatedAt((new Datetime)->setDate(2016, 05, 05)->setTime(12, 01));

        $album2 = new Album();
        $album2->setName('Album 2');
        $album2->setCreatedAt((new Datetime)->setDate(2016, 05, 05)->setTime(12, 02));

        return [$album, $album2];
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockEntityManager()
    {
        $entityManager = $this
            ->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Use it globally during the test
        $this->container->set('doctrine.orm.default_entity_manager', $entityManager);

        return $entityManager;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function mockAlbumRepository()
    {
        return $this
            ->getMockBuilder(AlbumRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}