<?php

/**
 * @file
 * * Contains \Drupal\mymodule\Plugin\Block\Copyright.
 */
namespace Drupal\album\Plugin\Block;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Access\AccessResult;

/**
 * @Block(
 * id = "copyright_block",
 * admin_label = @Translation("Copyright"),
 * category = @Translation("Custom")
 * )
 */

class Copyright extends BlockBase implements ContainerFactoryPluginInterface {

  protected $routeMatch;

  /**
   * Copyright block constructor.
   *
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   \Drupal\album\AlbumService instance.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match')
    );
  }


  public function build() {
    $date = new \DateTime();
    return [
      '#markup' => t('Copyright @year&copy; @company', [
        '@year' => $date->format('Y'),
        '@company' => $this->configuration['company_name'],
      ]),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'company_name' => '',
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, \Drupal\Core\Form\FormStateInterface $form_state) {

    $form['company_name'] = [
      '#type' => 'textfield',
      '#title' => t('Company name'),
      '#default_value' => $this->configuration['company_name'],
    ];
    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, \Drupal\Core\Form\FormStateInterface $form_state) {

    /*// Load the manager service.
    $unit_manager = \Drupal::service('plugin.manager.unit');
    // Create a class instance through the manager.
    $feet_instance = $unit_manager->createInstance('feet');
    // Convert 12ft into meters.
    $meters_value = $feet_instance->toBase(12);*/

    $this->configuration['company_name'] = $form_state->getValue('company_name');
    /*$this->configuration['company_name'] = $meters_value;*/
 }

  /**
   * {@inheritdoc}
   */

  protected function blockAccess(AccountInterface $account) {
    $route_name = $this->routeMatch->getRouteName();
    if ($account->isAnonymous() && !in_array($route_name,
        array('user.login', 'user.logout'))) {
      return AccessResult::allowed()->addCacheContexts(['route.name', 'user.roles:anonymous']);
    }
    return AccessResult::forbidden();
  }

}
