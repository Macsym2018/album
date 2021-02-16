<?php

/**
 * @file
 * * Contains \Drupal\mymodule\Plugin\Block\Copyright.
 */
namespace Drupal\album\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 * id = "copyright_block",
 * admin_label = @Translation("Copyright"),
 * category = @Translation("Custom")
 * )
 */

class Copyright extends BlockBase {

  public function build() {
    $date = new \DateTime();
    return [
      '#markup' => t('Copyright @year&copy; My Company', [
        '@year' => $date->format('Y'),
      ]),
    ];
  }

}
