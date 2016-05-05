<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GalleryController extends Controller
{
    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('gallery/home.html.twig');
    }

    /**
     * Show albums.
     *
     * @Route("/albums", name="gallery.albums")
     * @Method("GET")
     */
    public function albumsAction()
    {
        $albums = $this->container->get('gallery')->albums();

        return new JsonResponse([
            'data' => $albums,
        ]);
    }

    /**
     * Show pictures list from an album.
     *
     * @Route("/album/{id}/pictures", name="gallery.pictures")
     * @Method("GET")
     * @param $id
     * @return JsonResponse
     */
    public function picturesAction($id)
    {
        $request = $this->container->get('request');
        list($pictures, $paginator) = $this->container->get('gallery')->pictures(
            $id,
            $request->get('page', 1)
        );

        return new JsonResponse([
            'data' => $pictures,
            'paginator' => $paginator,
        ]);
    }

    /**
     * Show a particular picture info.
     *
     * @Route("/picture/{id}", name="gallery.picture")
     * @Method("GET")
     * @param $id
     */
    public function pictureAction($id)
    {
        $picture = $this->container->get('gallery')->picture($id);

        return new JsonResponse([
            'data' => $picture,
        ]);
    }
}
