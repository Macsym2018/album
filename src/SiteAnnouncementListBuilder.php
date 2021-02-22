<?php
/**
 * @file
 * Contains \Drupal\album\SiteAnnouncementListBuilder.
 */
namespace Drupal\album;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\album\Entity\SiteAnnouncementInterface;
use Drupal\Core\Entity\EntityInterface;

class SiteAnnouncementListBuilder extends ConfigEntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = t('Label');
    return $header + parent::buildHeader();
  }
  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $entity->label();
    return $row + parent::buildRow($entity);
  }
}
