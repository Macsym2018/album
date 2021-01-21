<?php

namespace Drupal\album;

use GuzzleHttp\ClientInterface;


class AlbumService{

  private $httpClient;

  function __construct(ClientInterface $http_client){
    $this->httpClient=$http_client;
  }

  public function getAlbums(){

    $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/albums');
    $albums=json_decode($response->getBody()->getContents());

    return $albums;
  }

  public function getAlbumPhotos($albumId){

    $response = $this->httpClient->request('GET', 'https://jsonplaceholder.typicode.com/photos');
    $photos=json_decode($response->getBody()->getContents());

    foreach ($photos as $photo){
      if($photo->albumId==$albumId){
        $album[]=[
          'albumId'=>$photo->albumId,
          'id'=>$photo->id,
          'title'=>$photo->title,
          'url'=>$photo->url,
          'thumbnailUrl'=>$photo->thumbnailUrl,
        ];
      }
    }

    return $album;

  }

}
