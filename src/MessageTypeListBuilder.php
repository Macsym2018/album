<?php
/**
 * @file Contains \Drupal\album\MessageListBuilder
 */
namespace Drupal\album;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityListBuilder;

class MessageTypeListBuilder extends EntityListBuilder {

  public function buildHeader() {

    $header['label'] = t('Message type');
    return $header + parent::buildHeader();

  }
  public function buildRow(EntityInterface $entity) {

    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);

  }

}
