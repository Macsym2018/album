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
   *   Return array that contain all photos depend on almum id.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getAlbumPhotos($albumId) {

    if ($cache = \Drupal::cache()->get('photos:album_photos_cache_data:' . $albumId)) {
      $album = $cache->data;
    }
    else {
      $tags = ['album_id:' . $albumId];

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

      if ($album) {
        \Drupal::cache()->set('photos:album_photos_cache_data:' . $albumId, $album, REQUEST_TIME + (3600), $tags);
      }

    }
    return $album;
  }

  /**
   * Get all Photos from link depends on album id.
   *
   * @param string $userId
   *   User's ID.
   *
   * @return array
   *   Return array that contain all albums depend on user id.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getAlbumsByUserId($userId) {
    if ($cache = \Drupal::cache()->get('photos:albums_cache_data:' . $userId)) {
      $albums = $cache->data;
    }
    else {
      $tags = ['user_id:' . $userId];

      $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/albums');
      $allAlbums = json_decode($response->getBody()->getContents());

      if ($allAlbums) {
        foreach ($allAlbums as $album) {
          if ($album->userId == $userId) {
            $albums[$album->id] = $album->title;
          }
        }

        if ($albums) {
          \Drupal::cache()->set('photos:albums_cache_data:' . $userId, $albums, REQUEST_TIME + (3600), $tags);
        }

        return $albums;
      }
      else {
        return [];
      }
    }
    return $albums;
  }

}
