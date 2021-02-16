<?php
/**
 * @file
 * Contains \Drupal\album\UnitManager.
 */
namespace Drupal\album;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

class UnitManager extends DefaultPluginManager {
  /**
   * Default values for each unit plugin.
   *
   * @var array
   */
  protected $defaults = [
    'id' => '',
    'label' => '',
    'unit' => '',
    'factor' => 0.00,
    'type' => '',
    'class' => 'Drupal\album\Unit',
  ];

  /**
   * Constructs a new \Drupal\almub\UnitManager object.
   *
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   * Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   * The module handler to invoke the alter hook with.
   */

  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->moduleHandler = $module_handler;
    $this->setCacheBackend($cache_backend, 'physical_unit_plugins');
  }


  /*public function __construct($subdir, Traversable $namespaces, ModuleHandlerInterface $module_handler, $plugin_interface = NULL, $plugin_definition_annotation_name = 'Drupal\Component\Annotation\Plugin', array $additional_annotation_namespaces = [], CacheBackendInterface $cache_backend) {
    $this->subdir = $subdir;
    $this->namespaces = $namespaces;
    $this->pluginDefinitionAnnotationName = $plugin_definition_annotation_name;
    $this->pluginInterface = $plugin_interface;
    $this->additionalAnnotationNamespaces = $additional_annotation_namespaces;
    $this->moduleHandler = $module_handler;
    $this->setCacheBackend($cache_backend, 'physical_unit_plugins');
  }*/

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('units', $this->moduleHandler->getModuleDirectories());
      $this->discovery = new ContainerDerivativeDiscoveryDecorator($this->discovery);
    }
    return $this->discovery;
  }

}
