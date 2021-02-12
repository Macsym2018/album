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

  /**
   * Return Content.
   *
   * @return array
   *   Return text
   */
  public function formContent() {

    $form = \Drupal::formBuilder()->getForm('Drupal\photos\Form\PhotosForm');
    $form['#attached']['library'][] = 'photos/global-styling';

    return [
      '#theme' => 'photos_template',
      '#form' => $form,
    ];
  }

}
