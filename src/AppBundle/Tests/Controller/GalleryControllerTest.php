<?php

namespace AppBundle\Tests\Controller;

use Closure;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class GalleryControllerTest extends WebTestCase
{
    /** @test */
    public function it_fetches_albums_list()
    {
        return $this->fetchAlbums(function ($albums, JsonResponse $response) {
            $this->assertStatus200($response);
            $this->assertArrayHasKey('data', $albums);
            $this->assertNotEmpty($albums['data']);
        });
    }

    /**
     * @test
     * @depends it_fetches_albums_list
     */
    public function it_fetches_album_images($albums)
    {
        $this->assertArrayHasKey(
            'covers',
            $album = $this->firstAlbum($albums)
        );

        $this->assertStatus200(
            $response = $this->callApi($album['resource'])
        );

        $fullInfo = json_decode($response->getContent(), true);

        $this->assertArrayHasKeys(['data', 'paginator'], $fullInfo);

        return $album;
    }

    /**
     * @test
     * @depends it_fetches_album_images
     */
    public function it_fetches_an_image($album)
    {
        $picture = $album['covers'][0];

        $this->assertStatus200(
            $response = $this->callApi($picture['resource'])
        );

        $response = json_decode($response->getContent(), true);

        $this->assertNotEmpty($data = $response['data']);

        $this->assertArrayHasKeys(
            ['id', 'thumbnail', 'path', 'note', 'albumId'],
            $data
        );
    }

    /**
     * @param string $url API url
     * @param string $method Request Method
     * @return null|\Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function callApi($url, $method = 'GET')
    {
        $client = static::createClient();

        $client->request($method, $url);

        return $client->getResponse();
    }

    /**
     * @param Closure $callback
     * @return mixed
     */
    protected function fetchAlbums(Closure $callback = null)
    {
        $response = $this->callApi('/albums');

        $albums = json_decode($response->getContent(), true);

        if (!is_null($callback)) {
            call_user_func_array($callback, [$albums, $response]);
        }

        return $albums;
    }

    /**
     * @param $albums
     */
    protected function firstAlbum($albums)
    {
        return $albums['data'][0];
    }

    /**
     * Assure the response status code is 200.
     * @param JsonResponse $response
     */
    protected function assertStatus200(JsonResponse $response)
    {
        $this->assertEquals($response->getStatusCode(), 200);

        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    /**
     * @param $keys
     * @param $data
     */
    protected function assertArrayHasKeys($keys, $data)
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $data);
        }
    }
}
