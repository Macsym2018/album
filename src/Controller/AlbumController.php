<?php

namespace Drupal\album\Controller;

use Drupal\Core\Controller\ControllerBase;


/**
 * Defines AlbumController class.
 */
class AlbumController extends ControllerBase {


  public function content() {
    return [
      '#markup' => $this->t('Hello, World!'),
    ];
  }

}
