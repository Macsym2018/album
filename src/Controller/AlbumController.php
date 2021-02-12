<?php

namespace Drupal\album\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Defines AlbumController class.
 */
class AlbumController extends ControllerBase {

  /**
   * Return Content.
   *
   * @return array
   *   Return text
   */
  public function content() {

    return [
      '#theme' => 'album_template',
      '#data' => 'Hello!',
    ];
  }

}
