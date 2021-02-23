<?php
/**
 * @file Contains \Drupal\album\Entity\MessageTypeInterface.
 */

namespace Drupal\album\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

interface MessageTypeInterface extends ConfigEntityInterface {
  /**
   * Gets the message value.
   *
   * @return string
   */
  public function getMessage();

}
