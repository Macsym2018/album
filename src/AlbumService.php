<?php

namespace Drupal\album;

use GuzzleHttp\ClientInterface;

/**
 * Class AlbumService. Provide something.
 *
 * @package Drupal\album.
 */
class AlbumService {

  /**
   * Guzzle\Client instance.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  private $httpClient;

  /**
   * AlbumService constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   Guzzle\Client instance.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * Get all albums from link.
   *
   * @return array
   *   Return array that contain all albums.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getAlbums() {

    $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/albums');
    $albums = json_decode($response->getBody()->getContents());

    return $albums;
  }

  /**
   * Get all Photos from link depends on album id.
   *
   * @param string $albumId
   *   Album's ID.
   *
   * @return array
   *   Return array that contain all photos depends on almum id.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getAlbumPhotos($albumId) {

    $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/photos');
    $photos = json_decode($response->getBody()->getContents());

    foreach ($photos as $photo) {
      if ($photo->albumId == $albumId) {
        $album[] = [
          'albumId' => $photo->albumId,
          'id' => $photo->id,
          'title' => $photo->title,
          'url' => $photo->url,
          'thumbnailUrl' => $photo->thumbnailUrl,
        ];
      }
    }

    return $album;

  }

}
